package com.hotel.billing;

import com.hotel.billing.BillingRequest;
import org.springframework.stereotype.Service;

import java.time.DayOfWeek;
import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.LocalTime;
import java.time.temporal.ChronoUnit;

@Service
public class BillingService {

    public double calcularValor(BillingRequest request) {
        LocalDateTime entrada = request.getDataEntrada();
        LocalDateTime saida = request.getDataSaida();
        int vagasGaragem = request.getVagasGaragem();

        double total = 0;

        // loop pelas datas
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

        // verificar se há diária extra
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
