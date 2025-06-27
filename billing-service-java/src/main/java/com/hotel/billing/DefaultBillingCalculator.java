package com.hotel.billing;

import org.springframework.stereotype.Component;
import java.time.DayOfWeek;
import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.LocalTime;

@Component
public class DefaultBillingCalculator implements BillingCalculator {

    @Override
    public boolean supports(BillingRequest request) {
        // Estratégia padrão, sempre retorna true
        return true;
    }

    @Override
    public double calcularValor(BillingRequest request) {
        LocalDateTime entrada = request.getDataEntrada();
        LocalDateTime saida = request.getDataSaida();
        int vagasGaragem = request.getVagasGaragem();

        double total = 0;
        LocalDate dataAtual = entrada.toLocalDate();
        LocalDate dataFinal = saida.toLocalDate();

        while (!dataAtual.isAfter(dataFinal)) {
            DayOfWeek dia = dataAtual.getDayOfWeek();
            boolean fimDeSemana = dia == DayOfWeek.SATURDAY || dia == DayOfWeek.SUNDAY;
            total += fimDeSemana ? 150 : 120;
            if (vagasGaragem > 0) {
                total += vagasGaragem * (fimDeSemana ? 20 : 15);
            }
            dataAtual = dataAtual.plusDays(1);
        }

        if (saida.toLocalTime().isAfter(LocalTime.of(16, 30))) {
            DayOfWeek dia = saida.getDayOfWeek();
            boolean fimDeSemana = dia == DayOfWeek.SATURDAY || dia == DayOfWeek.SUNDAY;
            total += fimDeSemana ? 150 : 120;
            if (vagasGaragem > 0) {
                total += vagasGaragem * (fimDeSemana ? 20 : 15);
            }
        }
        return total;
    }
}