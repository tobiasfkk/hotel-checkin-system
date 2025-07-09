package com.hotel.billing;

/**
 * DTO para resposta de cálculo de faturamento.
 * Contém o valor total calculado da hospedagem.
 * 
 * @author Hotel Check-in System
 * @version 1.0.0
 */
public class BillingResponse {
    
    /** Valor total da hospedagem em reais */
    private double valorTotal;

    /**
     * Construtor para criar resposta de faturamento.
     * 
     * @param valorTotal Valor total calculado da hospedagem
     */
    public BillingResponse(double valorTotal) {
        this.valorTotal = valorTotal;
    }

    /**
     * Obtém o valor total da hospedagem.
     * 
     * @return Valor total em reais
     */
    public double getValorTotal() {
        return valorTotal;
    }
}
