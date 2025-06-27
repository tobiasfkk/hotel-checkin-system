package com.hotel.billing;

public interface BillingCalculator {
    boolean supports(BillingRequest request);
    double calcularValor(BillingRequest request);
}