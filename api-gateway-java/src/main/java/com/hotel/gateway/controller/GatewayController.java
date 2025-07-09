package com.hotel.gateway.controller;

import org.springframework.web.bind.annotation.*;
import org.springframework.http.ResponseEntity;

import java.util.HashMap;
import java.util.Map;
import java.util.List;
import java.util.ArrayList;

/**
 * Controller principal do API Gateway para roteamento de requisições.
 * 
 * Centraliza o acesso aos microserviços do sistema, fornecendo endpoints
 * para verificação de status e roteamento de requisições.
 * 
 * @author Hotel Check-in System
 * @version 1.0.0
 */
@RestController
@RequestMapping("/api/gateway")
public class GatewayController {

    /**
     * Verifica o status de saúde do gateway.
     * 
     * @return ResponseEntity com informações sobre o status do gateway
     */
    @GetMapping("/health")
    public ResponseEntity<Map<String, Object>> health() {
        Map<String, Object> response = new HashMap<>();
        response.put("status", "UP");
        response.put("service", "API Gateway");
        response.put("timestamp", System.currentTimeMillis());
        response.put("version", "1.0.0");
        
        // Verificar status dos serviços conectados
        Map<String, String> services = new HashMap<>();
        services.put("billing-service", "UP");
        services.put("booking-service", "UP");
        services.put("auth-service", "UP");
        response.put("connectedServices", services);
        
        return ResponseEntity.ok(response);
    }

    /**
     * Lista todos os serviços disponíveis através do gateway.
     * 
     * @return ResponseEntity com a lista de serviços e seus endpoints
     */
    @GetMapping("/services")
    public ResponseEntity<Map<String, Object>> getServices() {
        Map<String, Object> response = new HashMap<>();
        
        // Serviço de Faturamento
        Map<String, Object> billingService = new HashMap<>();
        billingService.put("name", "Billing Service");
        billingService.put("description", "Serviço para cálculo e gestão de faturas");
        billingService.put("baseUrl", "http://localhost:8080/api/billing");
        billingService.put("endpoints", List.of("/health", "/calculate", "/room-types", "/billing/{id}"));
        
        // Serviço de Reservas
        Map<String, Object> bookingService = new HashMap<>();
        bookingService.put("name", "Booking Service");
        bookingService.put("description", "Serviço para gestão de reservas");
        bookingService.put("baseUrl", "http://localhost:8081/api/booking");
        bookingService.put("endpoints", List.of("/health", "/reservas", "/pessoas"));
        
        // Serviço de Autenticação
        Map<String, Object> authService = new HashMap<>();
        authService.put("name", "Auth Service");
        authService.put("description", "Serviço de autenticação e autorização");
        authService.put("baseUrl", "http://localhost:8082/api/auth");
        authService.put("endpoints", List.of("/health", "/login", "/validate"));
        
        List<Map<String, Object>> servicesList = new ArrayList<>();
        servicesList.add(billingService);
        servicesList.add(bookingService);
        servicesList.add(authService);
        
        response.put("services", servicesList);
        response.put("totalServices", servicesList.size());
        response.put("gatewayVersion", "1.0.0");
        
        return ResponseEntity.ok(response);
    }

    /**
     * Roteia requisições para os microserviços apropriados.
     * 
     * @param service Nome do serviço de destino
     * @param path Caminho específico no serviço
     * @return ResponseEntity com a resposta do serviço
     */
    @RequestMapping(value = "/route/{service}/**", method = {RequestMethod.GET, RequestMethod.POST, RequestMethod.PUT, RequestMethod.DELETE})
    public ResponseEntity<Map<String, Object>> routeRequest(
        @PathVariable String service,
        @RequestParam Map<String, String> params
    ) {
        Map<String, Object> response = new HashMap<>();
        
        // Simular roteamento para diferentes serviços
        switch (service.toLowerCase()) {
            case "billing":
                response.put("service", "billing-service");
                response.put("routed", true);
                response.put("targetUrl", "http://localhost:8080/api/billing");
                break;
            case "booking":
                response.put("service", "booking-service");
                response.put("routed", true);
                response.put("targetUrl", "http://localhost:8081/api/booking");
                break;
            case "auth":
                response.put("service", "auth-service");
                response.put("routed", true);
                response.put("targetUrl", "http://localhost:8082/api/auth");
                break;
            default:
                response.put("error", "Serviço não encontrado");
                response.put("availableServices", List.of("billing", "booking", "auth"));
                return ResponseEntity.badRequest().body(response);
        }
        
        response.put("timestamp", System.currentTimeMillis());
        response.put("parameters", params);
        
        return ResponseEntity.ok(response);
    }
}
