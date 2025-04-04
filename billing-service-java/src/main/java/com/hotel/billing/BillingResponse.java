package com.hotel.billing;

public class BillingResponse {
    private double valorTotal;

    public BillingResponse(double valorTotal) {
        this.valorTotal = valorTotal;
    }

    public double getValorTotal() {
        return valorTotal;
    }
}
