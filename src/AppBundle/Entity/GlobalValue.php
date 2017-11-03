<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

class GlobalValue{
    /*Roles*/
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_EMPRESA = 'ROLE_EMPRESA';
    const ROLE_VENDEDOR = 'ROLE_VENDEDOR';
    const ROLE_CARGADATOS = 'ROLE_CARGADATOS';
    const ROLE_DEPOSITO = 'ROLE_DEPOSITO';
    
    const ROLE_ADMIN_DISPLAY = 'Administrador';
    const ROLE_EMPRESA_DISPLAY = 'Empresa';
    const ROLE_VENDEDOR_DISPLAY = 'Vendedor';
    const ROLE_CARGADATOS_DISPLAY = 'Carga de Datos';
    const ROLE_DEPOSITO_DISPLAY = 'Deposito';
    
    const ROLES = 
            array(
                    GlobalValue::ROLE_ADMIN => GlobalValue::ROLE_ADMIN_DISPLAY,
                    GlobalValue::ROLE_EMPRESA => GlobalValue::ROLE_EMPRESA_DISPLAY,
                    GlobalValue::ROLE_VENDEDOR => GlobalValue::ROLE_VENDEDOR_DISPLAY,
                    GlobalValue::ROLE_CARGADATOS => GlobalValue::ROLE_CARGADATOS_DISPLAY,
                    GlobalValue::ROLE_DEPOSITO => GlobalValue::ROLE_DEPOSITO_DISPLAY
                );
    
    
    
    
    
    /*DIAS de la Semana*/
    const LUNES_DISPLAY = 'Lunes';
    const MARTES_DISPLAY = 'Martes';
    const MIERCOLES_DISPLAY = 'Miercoles';
    const JUEVES_DISPLAY = 'Jueves';
    const VIERNES_DISPLAY = 'Viernes';
    const SABADO_DISPLAY = 'Sabado';
    const DOMINGO_DISPLAY = 'Domingo';
    
    const LUNES_ID = 1;
    const MARTES_ID = 2;
    const MIERCOLES_ID = 3;
    const JUEVES_ID = 4;
    const VIERNES_ID = 5;
    const SABADO_ID = 6;
    const DOMINGO_ID = 7;
    
    const DIAS_SEMANA = 
            array(
                    GlobalValue::LUNES_ID => GlobalValue::LUNES_DISPLAY,
                    GlobalValue::MARTES_ID => GlobalValue::MARTES_DISPLAY,
                    GlobalValue::MIERCOLES_ID => GlobalValue::MIERCOLES_DISPLAY,
                    GlobalValue::JUEVES_ID => GlobalValue::JUEVES_DISPLAY,
                    GlobalValue::VIERNES_ID => GlobalValue::VIERNES_DISPLAY,
                    GlobalValue::SABADO_ID => GlobalValue::SABADO_DISPLAY,
                    GlobalValue::DOMINGO_ID => GlobalValue::DOMINGO_DISPLAY
                );
    
    const DIAS_SEMANA_SELECT = 
            array(
                    GlobalValue::LUNES_DISPLAY => GlobalValue::LUNES_ID  ,
                    GlobalValue::MARTES_DISPLAY => GlobalValue::MARTES_ID ,
                    GlobalValue::MIERCOLES_DISPLAY => GlobalValue::MIERCOLES_ID,
                    GlobalValue::JUEVES_DISPLAY => GlobalValue::JUEVES_ID ,
                    GlobalValue::VIERNES_DISPLAY => GlobalValue::VIERNES_ID ,
                    GlobalValue::SABADO_DISPLAY => GlobalValue::SABADO_ID ,
                    GlobalValue::DOMINGO_DISPLAY => GlobalValue::DOMINGO_ID 
                );
    
    
    
    
    
    /*Estado de pedido*/
    const PENDIENTE = 1;
    const ENVIADO = 2;
    const ENTREGADO = 3;
    const PAGADO = 4;
    
    const PENDIENTE_DISPLAY = 'Pendiente';
    const ENVIADO_DISPLAY = 'Pendiente (Android)';
    const ENTREGADO_DISPLAY = 'Entregado';
    const PAGADO_DISPLAY = 'Pagado';
    
    const ESTADOS = array(
                          GlobalValue::PENDIENTE =>GlobalValue::PENDIENTE_DISPLAY,
                          GlobalValue::ENVIADO => GlobalValue::ENVIADO_DISPLAY,
                          GlobalValue::ENTREGADO => GlobalValue::ENTREGADO_DISPLAY,
                          GlobalValue::PAGADO => GlobalValue::PAGADO_DISPLAY);
    
    const ESTADOS_SELECT = 
                        array(
                          GlobalValue::PENDIENTE_DISPLAY =>GlobalValue::PENDIENTE ,
                          GlobalValue::ENVIADO_DISPLAY => GlobalValue::ENVIADO ,
                          GlobalValue::ENTREGADO_DISPLAY => GlobalValue::ENTREGADO,
                          GlobalValue::PAGADO_DISPLAY=> GlobalValue::PAGADO
                        );
    
    //Tipo de Movimientos
    const INGRESO = 1;
    const EGRESO = 2;
  
    const INGRESO_DISPLAY = 'Ingreso';
    const EGRESO_DISPLAY = 'Egreso';
    
    const TIPOMOVIMIENTOS = array(
                                GlobalValue::INGRESO =>GlobalValue::INGRESO_DISPLAY,
                                GlobalValue::EGRESO => GlobalValue::EGRESO_DISPLAY,
                        );
    
    const TIPOMOVIMIENTOS_SELECT = 
                        array(
                                GlobalValue::INGRESO_DISPLAY =>GlobalValue::INGRESO ,
                                GlobalValue::EGRESO_DISPLAY => GlobalValue::EGRESO ,  
                        );
    
    //Tipos de Archivos
    const ARCHIVO_PRODUCTOS = 1;
    const ARCHIVO_CLIENTES = 2;
    const ARCHIVO_CATEGORIAS = 3;
    
    const ARCHIVO_PRODUCTOS_DISPLAY = 1;
    const ARCHIVO_CLIENTES_DISPLAY = 2;
    const ARCHIVO_CATEGORIAS_DISPLAY = 3;
    
    //Tipos de Archivos
    const ARCHIVO_ESTADO_UPLOAD = 1;
    const ARCHIVO_ESTADO_PROCESADO = 2;
    const ARCHIVO_ESTADO_ERROR_UPLOAD = 3;
    const ARCHIVO_ESTADO_ERROR_PROCESADO = 4;
    
    
    const ARCHIVO_TIPO_SELECT = 
                        array(
                                GlobalValue::ARCHIVO_PRODUCTOS_DISPLAY =>GlobalValue::ARCHIVO_PRODUCTOS ,
                                GlobalValue::ARCHIVO_CLIENTES_DISPLAY => GlobalValue::ARCHIVO_CLIENTES ,  
                                GlobalValue::ARCHIVO_CATEGORIAS_DISPLAY => GlobalValue::ARCHIVO_CATEGORIAS ,  
                        );
    
}