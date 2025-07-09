package com.hotel.billing;

import com.hotel.billing.BillingRequest;
import com.hotel.billing.BillingResponse;
import com.hotel.billing.BillingService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/billing")
public class BillingController {

    @Autowired
    private BillingService billingService;

    @PostMapping
    public BillingResponse calcular(@RequestBody BillingRequest request) {
        double valor = billingService.calcularValor(request);
        return new BillingResponse(valor);
    }
}