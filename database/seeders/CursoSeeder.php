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
        $this->limpiarDatos();
        $this->crearAsignaturas();
        $this->crearCursos();
    }

    private function limpiarDatos(): void
    {
        Curso::query()->delete();
        Asignatura::query()->delete();
    }

    private function crearAsignaturas(): void
    {
        $asignaturasUnicas = collect(self::asignaturas)->unique('Codigo');
        
        foreach ($asignaturasUnicas as $asignatura) {
            Asignatura::create([
                'codigo' => $asignatura['Codigo'],
                'nombre' => $asignatura['Nombre'],
            ]);
        }
    }

    private function crearCursos(): void
    {
        $asignaturas = Asignatura::all();
        
        foreach ($asignaturas as $asignatura) {
            $clases = collect(self::asignaturas)->where('Codigo', $asignatura->codigo)->values();
            $periodo = $this->obtenerPeriodo($clases[0]['Cuatrimestre']);
            
            $curso = $this->crearCurso($asignatura, $periodo, $clases->count());
            $this->asignarDocentes($curso);
            $this->crearSlots($curso, $clases);
        }
    }

    private function obtenerPeriodo(string $cuatrimestre): Periodo
    {
        return Periodo::where('nombre', '2024-2025 ' . $cuatrimestre)->first();
    }

    private function crearCurso(Asignatura $asignatura, Periodo $periodo, int $totalClases): Curso
    {
        return Curso::create([
            'nombre' => $asignatura->nombre,
            'asignatura_id' => $asignatura->id,
            'periodo_id' => $periodo->id,
            'alumnos_matriculados' => rand(10, 22),
            'total_clases_curso' => $totalClases,
        ]);
    }

    private function asignarDocentes(Curso $curso): void
    {
        $docentes = User::where('tipo', 'Responsable')->inRandomOrder()->take(rand(1, 2))->get();
        $curso->docentes()->attach($docentes->pluck('id'));
    }

    private function crearSlots(Curso $curso, $clases): void
    {
        $fechaInicio = Carbon::parse($curso->periodo->fecha_inicio);
        $fechaActual = $fechaInicio->copy();
    
        foreach ($clases as $clase) {
            $diaClase = $this->obtenerDiaSemana($clase['Dia']);
            
            // Avanzar hasta el próximo día de clase válido
            while ($fechaActual->dayOfWeek !== Carbon::parse($diaClase)->dayOfWeek || 
                   $curso->slots()->where('dia', $fechaActual->toDateString())->exists()) {
                $fechaActual->addDay();
            }
    
            $curso->slots()->create([
                'dia' => $fechaActual->toDateString(),
                'hora_inicio' => $this->formatearHora($clase['Hora'], 'inicio'),
                'hora_fin' => $this->formatearHora($clase['Hora'], 'fin'),
            ]);
    
            // Avanzar al siguiente día para la próxima iteración
            $fechaActual->addDay();
        }
    }

    private function obtenerDiaSemana(string $dia): string
    {
        return [
            'L' => 'Monday', 'M' => 'Tuesday', 'X' => 'Wednesday',
            'J' => 'Thursday', 'V' => 'Friday', 'S' => 'Saturday', 'D' => 'Sunday'
        ][$dia];
    }

    private function formatearHora(string $hora, string $tipo): string
    {
        $partes = explode(' a ', strtolower($hora));
        return ($tipo === 'inicio' ? $partes[0] : $partes[1]) . ':00';
    }
}
