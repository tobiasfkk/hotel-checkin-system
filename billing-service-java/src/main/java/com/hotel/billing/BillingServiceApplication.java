package com.hotel.billing;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

/**
 * Aplicação principal do serviço de faturamento do hotel.
 * 
 * Este microserviço é responsável por calcular valores de hospedagem,
 * gerenciar taxas e processar faturamento para o sistema de check-in.
 * 
 * @author Equipe de Desenvolvimento
 * @version 1.0.0
 * @since 2025
 */
@SpringBootApplication
public class BillingServiceApplication {

	/**
	 * Método principal para inicialização da aplicação Spring Boot.
	 * 
	 * @param args argumentos de linha de comando
	 */
	public static void main(String[] args) {
		SpringApplication.run(BillingServiceApplication.class, args);
	}

}
