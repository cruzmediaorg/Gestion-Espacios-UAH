<?php

namespace App;

enum ReservaType: string
{
    case ClasePractica = 'Clase Práctica';
    case ClaseTeorica = 'Clase Teórica';
    case TFGTFM = 'TFG/TFM';
    case Reunion = 'Reunión';
    case Examen = 'Examen';
    case Conferencia = 'Conferencia';
    case ConsejoDpt = 'Consejo de Departamento';
    case Otro = 'Otro';
}
