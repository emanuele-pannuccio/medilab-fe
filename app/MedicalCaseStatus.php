<?php

namespace App;

enum MedicalCaseStatus: string
{
 case aperto = "Aperto";
 case analisi = "Analisi";
 case revisione = "Revisione";
 case chiuso = "Chiuso";
}
