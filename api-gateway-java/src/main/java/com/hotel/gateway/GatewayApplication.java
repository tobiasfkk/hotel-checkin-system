package com.hotel.gateway;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

/**
 * Aplicação principal do API Gateway do Hotel Check-in System.
 * 
 * Este gateway centraliza o acesso aos microserviços do sistema de check-in do hotel,
 * fornecendo um ponto único de entrada para todas as APIs.
 * 
 * @author Hotel Check-in System
 * @version 1.0.0
 */
@SpringBootApplication
public class GatewayApplication {

    /**
     * Método principal para inicializar a aplicação Spring Boot.
     * 
     * @param args Argumentos da linha de comando
     */
    public static void main(String[] args) {
        SpringApplication.run(GatewayApplication.class, args);
    }
}
