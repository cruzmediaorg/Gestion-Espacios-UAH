<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use App\Models\Curso;
use App\Models\CursoSlot;
use App\Models\Grado;
use App\Models\Periodo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CursoSeeder extends Seeder
{
const asignaturas = [
        ["Codigo" => "100313", "Nombre" => "Ciencia Cognitiva: Cerebro", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "100313", "Nombre" => "Ciencia Cognitiva: Cerebro", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "10 a 12"],
        ["Codigo" => "780043", "Nombre" => "Calidad", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "17 a 19"],
        ["Codigo" => "780043", "Nombre" => "Calidad", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "16 a 17"],
        ["Codigo" => "780043", "Nombre" => "Calidad", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "17 a 19"],
        ["Codigo" => "780015", "Nombre" => "Ingeniería del Software", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "15 a 17"],
        ["Codigo" => "780015", "Nombre" => "Ingeniería del Software", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "100009", "Nombre" => "Búsqueda y Gestión de la Información y Recursos Multimedia", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "17 a 19"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "780021", "Nombre" => "Algoritmia y Complejidad", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "15 a 17"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "15 a 17"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "19 a 21"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "08 a 10"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "592014", "Nombre" => "Programación Declarativa", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "13 a 15"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "15 a 17"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "780022", "Nombre" => "Gestión de proyectos", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780024", "Nombre" => "Inteligencia Artificial", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "08 a 10"],
        ["Codigo" => "780024", "Nombre" => "Inteligencia Artificial", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780024", "Nombre" => "Inteligencia Artificial", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "08 a 10"],
        ["Codigo" => "780024", "Nombre" => "Inteligencia Artificial", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "780024", "Nombre" => "Inteligencia Artificial", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "15 a 17"],
        ["Codigo" => "780024", "Nombre" => "Inteligencia Artificial", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "15 a 17"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "15 a 17"],
        ["Codigo" => "780013", "Nombre" => "Matemáticas Avanzadas", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "08 a 10"],
        ["Codigo" => "780013", "Nombre" => "Matemáticas Avanzadas", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "12 a 14"],
        ["Codigo" => "780016", "Nombre" => "Bases de Datos", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "780016", "Nombre" => "Bases de Datos", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "08 a 10"],
        ["Codigo" => "780020", "Nombre" => "Bases de Datos Avanzadas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "780020", "Nombre" => "Bases de Datos Avanzadas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "08 a 10"],
        ["Codigo" => "780021", "Nombre" => "Algoritmia y Complejidad", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "8 a 10"],
        ["Codigo" => "780020", "Nombre" => "Bases de Datos Avanzadas", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "15 a 17"],
        ["Codigo" => "780015", "Nombre" => "Ingeniería del Software", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780020", "Nombre" => "Bases de Datos Avanzadas", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "780022", "Nombre" => "Gestión de proyectos", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "17 a 19"],
        ["Codigo" => "590000", "Nombre" => "Desarrollo del software", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "08 a 10"],
        ["Codigo" => "590000", "Nombre" => "Desarrollo del software", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "780016", "Nombre" => "Bases de Datos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "08 a 10"],
        ["Codigo" => "780016", "Nombre" => "Bases de Datos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "12 a 14"],
        ["Codigo" => "780021", "Nombre" => "Algoritmia y Complejidad", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "8 a 10"],
        ["Codigo" => "100002", "Nombre" => "Capacitación TIC'S", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "10 a 12"],
        ["Codigo" => "580015", "Nombre" => "Seguridad en Sistemas Distribuidos", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "17 a 19"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "08 a 10"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "781000", "Nombre" => "Programación", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "08 a 10"],
        ["Codigo" => "781000", "Nombre" => "Programación", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "15 a 17"],
        ["Codigo" => "781000", "Nombre" => "Programación", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "100009", "Nombre" => "Búsqueda y Gestión de la Información y Recursos Multimedia", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "9 a 11"],
        ["Codigo" => "592007", "Nombre" => "Metodología de la programación", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "641008", "Nombre" => "Tecnología de los Medios Audiovisuales", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "15 a 19"],
        ["Codigo" => "780022", "Nombre" => "Gestión de proyectos", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "15 a 17"],
        ["Codigo" => "780022", "Nombre" => "Gestión de proyectos", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "19 a 21"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "780014", "Nombre" => "Programación Avanzada", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "8 a 10"],
        ["Codigo" => "780041", "Nombre" => "Arquitectura y diseño de sistemas Web y C/S", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "10 a 12"],
        ["Codigo" => "780041", "Nombre" => "Arquitectura y diseño de sistemas Web y C/S", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "16 a 18"],
        ["Codigo" => "780042", "Nombre" => "Patrones Software", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "15 a 17"],
        ["Codigo" => "780042", "Nombre" => "Patrones Software", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "19 a 21"],
        ["Codigo" => "781000", "Nombre" => "Programación", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "08 a 10"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "08 a 10"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "15 a 17"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "19 a 21"],
        ["Codigo" => "780015", "Nombre" => "Ingeniería del Software", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "08 a 10"],
        ["Codigo" => "780015", "Nombre" => "Ingeniería del Software", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "780015", "Nombre" => "Ingeniería del Software", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "15 a 17"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "08 a 10"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "15 a 17"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "08 a 10"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "08 a 10"],
        ["Codigo" => "610031", "Nombre" => "Procesos de Organización Industrial", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "19 a 21"],
        ["Codigo" => "610031", "Nombre" => "Procesos de Organización Industrial", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "15 a 17"],
        ["Codigo" => "610032", "Nombre" => "Proyectos", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "17 a 19"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "15 a 17"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "19 a 21"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "12 a 14"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "08 a 10"],
        ["Codigo" => "581005", "Nombre" => "Paradigmas de Programación", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "17 a 19"],
        ["Codigo" => "581005", "Nombre" => "Paradigmas de Programación", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "780014", "Nombre" => "Programación Avanzada", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "10 a 12"],
        ["Codigo" => "780014", "Nombre" => "Programación Avanzada", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "17 a 19"],
        ["Codigo" => "581005", "Nombre" => "Paradigmas de Programación", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "581005", "Nombre" => "Paradigmas de Programación", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "17 a 19"],
        ["Codigo" => "780014", "Nombre" => "Programación Avanzada", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "10 a 12"],
        ["Codigo" => "780014", "Nombre" => "Programación Avanzada", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "17 a 19"],
        ["Codigo" => "780016", "Nombre" => "Bases de Datos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "17 a 19"],
        ["Codigo" => "781000", "Nombre" => "Programación", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "781000", "Nombre" => "Programación", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "781000", "Nombre" => "Programación", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "15 a 17"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "12 a 14"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "15 a 17"],
        ["Codigo" => "580011", "Nombre" => "Desarrollo con tecnologías emergentes", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "15 a 17"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "15 a 17"],
        ["Codigo" => "780015", "Nombre" => "Ingeniería del Software", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "08 a 10"],
        ["Codigo" => "780015", "Nombre" => "Ingeniería del Software", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "12 a 14"],
        ["Codigo" => "580000", "Nombre" => "Sistemas operativos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "08 a 10"],
        ["Codigo" => "580000", "Nombre" => "Sistemas operativos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "580000", "Nombre" => "Sistemas operativos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "15 a 17"],
        ["Codigo" => "780014", "Nombre" => "Programación Avanzada", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "100002", "Nombre" => "Capacitación TIC'S", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "10 a 12"],
        ["Codigo" => "780019", "Nombre" => "Ingeniería del Software Avanzada", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "08 a 10"],
        ["Codigo" => "780019", "Nombre" => "Ingeniería del Software Avanzada", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "580017", "Nombre" => "Fundamentos del comercio electrónico", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "14 a 16"],
        ["Codigo" => "580017", "Nombre" => "Fundamentos del comercio electrónico", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "17 a 19"],
        ["Codigo" => "780022", "Nombre" => "Gestión de proyectos", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "780022", "Nombre" => "Gestión de proyectos", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "592003", "Nombre" => "Fundamentos de la programación", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "09 a 11"],
        ["Codigo" => "781002", "Nombre" => "Computación Ubicua", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "12 a 14"],
        ["Codigo" => "600021", "Nombre" => "Proyectos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "10 a 12"],
        ["Codigo" => "780016", "Nombre" => "Bases de Datos", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "780022", "Nombre" => "Gestión de proyectos", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "592007", "Nombre" => "Metodología de la programación", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "592008", "Nombre" => "Estructuras de datos", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "12 a 14"],
        ["Codigo" => "592008", "Nombre" => "Estructuras de datos", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "12 a 14"],
        ["Codigo" => "780018", "Nombre" => "Procesadores de Lenguajes", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "08 a 10"],
        ["Codigo" => "780018", "Nombre" => "Procesadores de Lenguajes", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "780018", "Nombre" => "Procesadores de Lenguajes", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "15 a 17"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "15 a 17"],
        ["Codigo" => "781003", "Nombre" => "Planificación automática", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "781003", "Nombre" => "Planificación automática", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "15 a 17"],
        ["Codigo" => "780014", "Nombre" => "Programación Avanzada", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780014", "Nombre" => "Programación Avanzada", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "17 a 19"],
        ["Codigo" => "781004", "Nombre" => "Paradigmas Avanzados de Programación", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "08 a 10"],
        ["Codigo" => "580003", "Nombre" => "Redes", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "08 a 10"],
        ["Codigo" => "580003", "Nombre" => "Redes", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "15 a 17"],
        ["Codigo" => "580003", "Nombre" => "Redes", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "08 a 10"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "08 a 10"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "15 a 17"],
        ["Codigo" => "780021", "Nombre" => "Algoritmia y Complejidad", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "780025", "Nombre" => "Conocimiento y Razonamiento Automatizado", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "08 a 10"],
        ["Codigo" => "780025", "Nombre" => "Conocimiento y Razonamiento Automatizado", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "580003", "Nombre" => "Redes", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "580015", "Nombre" => "Seguridad en Sistemas Distribuidos", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "19 a 21"],
        ["Codigo" => "580015", "Nombre" => "Seguridad en Sistemas Distribuidos", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => " 17 a 19"],
        ["Codigo" => "781000", "Nombre" => "Programación", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "19 a 21"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "15 a 17"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "19 a 21"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "15 a 17"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "17 a 19"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "15 a 17"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "19 a 21"],
        ["Codigo" => "580008", "Nombre" => "Modelos y Tecnologías para los Sist.de Inform.", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "19 a 21"],
        ["Codigo" => "780020", "Nombre" => "Bases de Datos Avanzadas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "19 a 21"],
        ["Codigo" => "780023", "Nombre" => "Sistemas empresariales", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "08 a 10"],
        ["Codigo" => "590000", "Nombre" => "Desarrollo del software", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "15 a 17"],
        ["Codigo" => "590000", "Nombre" => "Desarrollo del software", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "19 a 21"],
        ["Codigo" => "580008", "Nombre" => "Modelos y Tecnologías para los Sist.de Inform.", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "15 a 17"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "J", "Hora" => "19 a 21"],
        ["Codigo" => "781002", "Nombre" => "Computación Ubicua", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "08 a 10"],
        ["Codigo" => "781002", "Nombre" => "Computación Ubicua", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "15 a 17"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "12 a 14"],
        ["Codigo" => "780013", "Nombre" => "Matemáticas Avanzadas", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "15 a 17"],
        ["Codigo" => "780013", "Nombre" => "Matemáticas Avanzadas", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "19 a 21"],
        ["Codigo" => "592003", "Nombre" => "Fundamentos de la programación", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "13 a 15"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780016", "Nombre" => "Bases de Datos", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "08 a 10"],
        ["Codigo" => "780016", "Nombre" => "Bases de Datos", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "12 a 14"],
        ["Codigo" => "580000", "Nombre" => "Sistemas operativos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "19 a 21"],
        ["Codigo" => "780020", "Nombre" => "Bases de Datos Avanzadas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "19 a 21"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "17 a 19"],
        ["Codigo" => "780016", "Nombre" => "Bases de Datos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "15 a 17"],
        ["Codigo" => "780020", "Nombre" => "Bases de Datos Avanzadas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "15 a 17"],
        ["Codigo" => "780021", "Nombre" => "Algoritmia y Complejidad", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "15 a 17"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "15 a 17"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "15 a 17"],
        ["Codigo" => "780015", "Nombre" => "Ingeniería del Software", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "17 a 19"],
        ["Codigo" => "780019", "Nombre" => "Ingeniería del Software Avanzada", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "19 a 21"],
        ["Codigo" => "581001", "Nombre" => "Fundamentos de los Sistemas de Información", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "15 a 17"],
        ["Codigo" => "581006", "Nombre" => "Tecnología en los Negocios", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "15 a 17"],
        ["Codigo" => "581006", "Nombre" => "Tecnología en los Negocios", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "19 a 21"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "19 a 21"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "19 a 21"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780008", "Nombre" => "Estructuras discretas", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "15 a 17"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "08 a 10"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "08 a 10"],
        ["Codigo" => "781003", "Nombre" => "Planificación automática", "Cuatrimestre" => "C2", "Dia" => "X", "Hora" => "08 a 10"],
        ["Codigo" => "781004", "Nombre" => "Paradigmas Avanzados de Programación", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "10 a 12"],
        ["Codigo" => "781004", "Nombre" => "Paradigmas Avanzados de Programación", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "15 a 17"],
        ["Codigo" => "780001", "Nombre" => "Fundamentos Matemáticos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "12 A 14"],
        ["Codigo" => "780022", "Nombre" => "Gestión de proyectos", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "19 a 21"],
        ["Codigo" => "780015", "Nombre" => "Ingeniería del Software", "Cuatrimestre" => "C2", "Dia" => "L", "Hora" => "12 a 14"],
        ["Codigo" => "780019", "Nombre" => "Ingeniería del Software Avanzada", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "15 a 17"],
        ["Codigo" => "580011", "Nombre" => "Desarrollo con tecnologías emergentes", "Cuatrimestre" => "C2", "Dia" => "V", "Hora" => "19 a 21"],
        ["Codigo" => "581001", "Nombre" => "Fundamentos de los Sistemas de Información", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "08 a 10"],
        ["Codigo" => "581001", "Nombre" => "Fundamentos de los Sistemas de Información", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "591000", "Nombre" => "Compiladores", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "08 a 10"],
        ["Codigo" => "591000", "Nombre" => "Compiladores", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "12 a 14"],
        ["Codigo" => "591000", "Nombre" => "Compiladores", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "15 a 17"],
        ["Codigo" => "600021", "Nombre" => "Proyectos", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "14 a 16"],
        ["Codigo" => "780003", "Nombre" => "Fundamentos de programación", "Cuatrimestre" => "C1", "Dia" => "V", "Hora" => "17 a 19"],
        ["Codigo" => "780004", "Nombre" => "Estadística", "Cuatrimestre" => "C1", "Dia" => "L", "Hora" => "19 a 21"],
        ["Codigo" => "780009", "Nombre" => "Estructuras de Datos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "780018", "Nombre" => "Procesadores de Lenguajes", "Cuatrimestre" => "C1", "Dia" => "X", "Hora" => "15 a 17"],
        ["Codigo" => "780020", "Nombre" => "Bases de Datos Avanzadas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "08 a 10"],
        ["Codigo" => "780020", "Nombre" => "Bases de Datos Avanzadas", "Cuatrimestre" => "C2", "Dia" => "J", "Hora" => "12 a 14"],
        ["Codigo" => "780023", "Nombre" => "Sistemas empresariales", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "780023", "Nombre" => "Sistemas empresariales", "Cuatrimestre" => "C2", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "781006", "Nombre" => "Fundamentos de la Ciencia de Datos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "08 a 10"],
        ["Codigo" => "781006", "Nombre" => "Fundamentos de la Ciencia de Datos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "12 a 14"],
        ["Codigo" => "781006", "Nombre" => "Fundamentos de la Ciencia de Datos", "Cuatrimestre" => "C1", "Dia" => "M", "Hora" => "15 a 17"],
        ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Curso::all()->each->forceDelete();
        Asignatura::all()->each->forceDelete();

        $asignaturasSinRepetir = collect(self::asignaturas)->unique('Codigo');

        foreach ($asignaturasSinRepetir as $asignatura) {
            $asignaturaModel = Asignatura::create([
                'codigo' => $asignatura['Codigo'],
                'nombre' => $asignatura['Nombre'],
            ]);

            $cuatrimestre = $asignatura['Cuatrimestre'];

            $this->crearCurso($asignaturaModel, $cuatrimestre);
        }

    }

    private function crearCurso($asignatura, $cuatrimestre): void
    {
        // Creamos el curso
        $clases = collect(self::asignaturas)->where('Codigo', $asignatura->codigo)->all();


        $periodo = Periodo::where('nombre', '2024-2025 ' . $cuatrimestre)->first();

        $curso = Curso::create([
            'nombre' => $asignatura->nombre,
            'asignatura_id' => $asignatura->id,
            'periodo_id' => $periodo->id,
            'alumnos_matriculados' => rand(10, 22),
            'total_clases_curso' => 2,
        ]);

        // Asignar uno o 2 profesores de forma aleatoria

        $docentes = User::where('tipo', 'Responsable')->get();

        $docente1 = $docentes->random();
        $docente2 = $docentes->random();

        $cantidadProfesores = rand(1, 2);

        $curso->docentes()->attach($docente1->id);

        if ($cantidadProfesores === 2) {
            $curso->docentes()->attach($docente2->id);
        }


        Log::debug('Hay ' . count($clases) . ' clases para la asignatura ' . $asignatura->nombre);

        foreach ($clases as $key => $clase) {
            $this->crearClase($curso, $clase, $key);
        }
    }

    private function parseHora($hora, $tipo): string
    {
        $hora = strtolower($hora);
        $hora = explode(' a ', $hora);

        if ($tipo === 'inicio') {
            return $hora[0] . ':00:00';
        } else {
            return $hora[1] . ':00:00';
        }
    }

    private function crearClase(Curso $curso, array $clase, int $key): void
    {
        $dia = $this->diaEnNumero($clase['Dia']);
        $horaInicio = $this->parseHora($clase['Hora'], 'inicio');
        $horaFin = $this->parseHora($clase['Hora'], 'fin');

        $periodo = $curso->periodo;
        $fechaInicioPeriodo = $periodo->fecha_inicio;

        $diasOcupados = [];

        // Aseguramos que no haya repetición de asignaturas el mismo día
        for ($i = 0; $i < $curso->total_clases_curso; $i++) {
            $fechaClase = $this->calcularFecha($fechaInicioPeriodo, $dia, $i);
            while (in_array($fechaClase, $diasOcupados)) {
                $dia++;
                if ($dia > 7) $dia = 1;
                $fechaClase = $this->calcularFecha($fechaInicioPeriodo, $dia, $i);
            }
            $diasOcupados[] = $fechaClase;

            $curso->slots()->create([
                'dia' => $fechaClase,
                'hora_inicio' => $horaInicio,
                'hora_fin' => $horaFin,
            ]);
        }
    }

    private function diaEnNumero(string $dia): int
    {
        $dias = [
            'L' => 1,
            'M' => 2,
            'X' => 3,
            'J' => 4,
            'V' => 5,
            'S' => 6,
            'D' => 7,
        ];

        return $dias[$dia];
    }

    private function calcularFecha($fechaInicioPeriodo, int $dia, int $key): string
    {
        $fecha = Carbon::parse($fechaInicioPeriodo)->addDays(($dia - 1) + ($key * 7));
        return $fecha->toDateString();
    }

}
