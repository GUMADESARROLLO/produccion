// view_proceso_seco_ordenes_produccion
SELECT
	T0.id,	
	T0.num_orden,
	T0.id_productor,
	T1.nombre,
	T0.fecha_hora_inicio,
	T0.fecha_hora_final,
	TIMEDIFF(T0.fecha_hora_final,T0.fecha_hora_inicio) hrs_total_trabajadas,	
	CASE
    WHEN(( UNIX_TIMESTAMP(T0.fecha_hora_final) - UNIX_TIMESTAMP(T0.fecha_hora_inicio) ) / 3600 ) >= 24 THEN (( UNIX_TIMESTAMP(T0.fecha_hora_final) - UNIX_TIMESTAMP(T0.fecha_hora_inicio) ) / 7200 ) 
    ELSE (( UNIX_TIMESTAMP(T0.fecha_hora_final) - UNIX_TIMESTAMP(T0.fecha_hora_inicio) ) / 3600 )
	END AS Hrs_trabajadas,
	IFNULL((SELECT T2.PESO_PORCENT FROM view_proceso_seco_estadisticas T2 WHERE T2.num_orden = T0.num_orden AND T2.ID_ARTICULO =T0.id_jr),0) PESO_PORCENT,
	IFNULL((SELECT SUM(T1.PRODUCTO) FROM view_agrupado_detalle_requisas T1 WHERE T1.num_orden = T0.num_orden) ,0) TOTAL_BULTOS_UNDS
FROM
	pc_ordenes_produccion T0
	INNER JOIN productos T1 ON T1.idProducto = T0.id_productor
	WHERE T0.estado='S'

// view_proceso_seco_data_meteria_prima
SELECT
	T0.num_orden,
	T1.ID_ARTICULO,
	T1.ARTICULO,
	T1.DESCRIPCION_CORTA,
	SUM(T0.cantidad) AS CANTIDAD,
	T3.PESO_PORCENT,
	(SUM(T0.cantidad) * T3.PESO_PORCENT) AS KG ,
	T0.TIPO AS ID_TIPO_REQUISA,
	T2.NOMBRE AS TIPO_REQUISA
FROM
	pc_requisado_detalles T0
	INNER JOIN pc_productos_ordenes T1 ON T1.ID_ARTICULO = T0.id_articulos
	INNER JOIN pc_requisados_tipos T2 ON T2.ID = T0.TIPO	
	INNER JOIN view_proceso_seco_ordenes_produccion T3 ON T0.num_orden = T3.num_orden
	GROUP BY T0.num_orden,T0.id_articulos,T0.TIPO
	ORDER BY T0.TIPO

//VIEW_AGRUPADO_DETALLE_REQUISAS
	SELECT	 
		T0.num_orden,
		T0.ARTICULO,
		T0.DESCRIPCION_CORTA,
		sum( if(  T0.ID_TIPO_REQUISA = '1', T0.CANTIDAD , 0 ) ) AS LP_INICIAL,		 
		sum( if(  T0.ID_TIPO_REQUISA = '2', T0.CANTIDAD , 0 ) ) AS REQUISADO,		 
		sum( if(  T0.ID_TIPO_REQUISA = '3', T0.CANTIDAD , 0 ) ) AS LP_FINAL,		 
		sum( if(  T0.ID_TIPO_REQUISA = '4', T0.CANTIDAD , 0 ) ) AS MERMA,
		sum( if(  T0.ID_TIPO_REQUISA = '5', T0.CANTIDAD , 0 ) ) AS PRODUCTO
	FROM
	view_proceso_seco_data_meteria_prima T0 
	GROUP BY
		T0.ID_ARTICULO,
		T0.num_orden





//view_proceso_seco_estadisticas
SELECT
		T0.num_orden,
		T0.ID_ARTICULO,
		T0.DESCRIPCION_CORTA,( T0.LP_INICIAL + T0.REQUISADO ) REQUISA,
		T0.LP_FINAL AS PISO,
		(T0.MERMA / (( T0.LP_INICIAL + ( T0.REQUISADO ) - T0.LP_FINAL - T0.MERMA ) + T0.MERMA) *100) AS MERMA_PORCENT,
		( T0.LP_INICIAL + ( T0.REQUISADO ) - T0.LP_FINAL - T0.MERMA )  AS CONSUMO,
		( T0.LP_INICIAL + ( T0.REQUISADO ) - T0.LP_FINAL - T0.MERMA )  / (SELECT SUM(T1.PRODUCTO) FROM view_agrupado_detalle_requisas T1 WHERE T1.num_orden = T0.num_orden) PESO_PORCENT,	
		T0.MERMA
	FROM
		VIEW_AGRUPADO_DETALLE_REQUISAS T0 WHERE ( T0.LP_INICIAL + T0.REQUISADO ) > 0

//view_articulos_detalles
SELECT
	T0.id,
	T1.ID_PRODUCTO,
	T0.num_orden,
	T1.ID_ARTICULO,
	T1.ARTICULO,
	T1.DESCRIPCION_CORTA,
	SUM(T0.cantidad) AS CANTIDAD,
	T0.TIPO AS ID_TIPO_REQUISA,
	T2.NOMBRE AS TIPO_REQUISA,
	T0.created_at fecha_creacion
FROM
	pc_requisado_detalles T0
	INNER JOIN pc_productos_ordenes T1 ON T1.ID_ARTICULO = T0.id_articulos
	INNER JOIN pc_requisados_tipos T2 ON T2.ID = T0.TIPO	
	INNER JOIN view_proceso_seco_ordenes_produccion T3 ON T0.num_orden = T3.num_orden
	WHERE T0.TIPO <> 5
	GROUP BY T0.num_orden,T0.id_articulos,T0.TIPO,T0.id
	ORDER BY T0.TIPO

// VIEW_DETALLES_TIEMPOS_PAROS
	SELECT
	T3.id_row,
		T3.num_orden,
		T3.nombre,
    coalesce(sum(case when T3.turno = "Dia" then T3.cantidad end), 0) as Dia,
    coalesce(sum(case when T3.turno = "Noche" then T3.cantidad end), 0) as Noche,
		coalesce(sum(case when T3.turno = "Dia" then T3.numero_personas end), 0) as Personal_Dia,
		coalesce(sum(case when T3.turno = "Noche" then T3.numero_personas end), 0) as Personal_Noche
from ( SELECT
	T2.id as id_row,
	T0.num_orden,
	T2.ID as id_tiempo_paro,
	T2.NOMBRE as nombre,	
	T0.cantidad,
	T0.numero_personas,
	T1.id AS id_turno,
	T1.turno
FROM
	pc_detalle_tiempos_paro T0
	INNER JOIN turnos T1 ON T1.ID = T0.id_turno
	INNER JOIN pc_tiempos_paros T2 ON T2.id = T0.id_tipo_tiempo_paro
	WHERE T2.ACTIVO ='S') T3
group by id_tiempo_paro,T3.num_orden,T3.id_row


//bBASE PARA EL PROCEDIMIENTO DE ALMACENADO QUE ME DEVOLVERA ESTA TABLA 
SELECT t1.num_orden,
	t1.ARTICULO,t1.TIPO_REQUISA,
		case when t1.ARTICULO = "2IN00067" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM1',
		case when t1.ARTICULO = "2IN00078" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM2',
		case when t1.ARTICULO = "1IN00114" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM3',
		case when t1.ARTICULO = "1IN00027" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM4',
		case when t1.ARTICULO = "1IN00103" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM5',
		case when t1.ARTICULO = "1IN00141" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM6',
		case when t1.ARTICULO = "1IN00021" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM7',
		case when t1.ARTICULO = "1IN00067" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM8',
		case when t1.ARTICULO = "1IN00092" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM9',
		case when t1.ARTICULO = "1IN00052" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM10',
		case when t1.ARTICULO = "1IN00100" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM11',
		case when t1.ARTICULO = "1IN00112" then GROUP_CONCAT(t1.CANTIDAD) end as 'ITEM12'
FROM
	view_articulos_detalles t1 
	GROUP BY t1.num_orden,t1.ARTICULO,t1.ID_TIPO_REQUISA
ORDER BY
	t1.ID_TIPO_REQUISA	