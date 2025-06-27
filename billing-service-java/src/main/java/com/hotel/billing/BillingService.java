package com.hotel.billing;

import org.springframework.stereotype.Service;
import java.util.List;

@Service
public class BillingService {

    private final List<BillingCalculator> calculators;

    public BillingService(List<BillingCalculator> calculators) {
        this.calculators = calculators;
    }

    public double calcularValor(BillingRequest request) {
        return calculators.stream()
                .filter(c -> c.supports(request))
                .findFirst()
                .orElseThrow(() -> new IllegalStateException("Nenhuma estratégia encontrada"))
                .calcularValor(request);
    }
}