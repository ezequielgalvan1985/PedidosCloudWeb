<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

class GlobalValue{
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
    
    const LUNES_DISPLAY = 'Lunes';
    const MARTES_DISPLAY = 'Martes';
    const MIERCOLES_DISPLAY = 'Miercoles';
    const JUEVES_DISPLAY = 'Jueves';
    const VIERNES_DISPLAY = 'Viernes';
    const SABADOS_DISPLAY = 'Sabados';
    
    const LUNES_ID = 1;
    const MARTES_ID = 2;
    const MIERCOLES_ID = 3;
    const JUEVES_ID = 4;
    const VIERNES_ID = 5;
    const SABADOS_ID = 6;
}