<?php

namespace Database\Seeders;

use App\Models\Contacto;
use App\Models\Ficha;
use App\Models\Producto;
use App\Models\SolicitudSoporte;
use Illuminate\Database\Seeder;

// Seeder principal — inserta datos de prueba en las 4 tablas
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Fichas de estudiantes (Módulo 1)
        Ficha::insert([
            [
                'nombre'     => 'Ana García López',
                'email'      => 'ana.garcia@example.cl',
                'carrera'    => 'Ing. Civil Informática',
                'mensaje'    => 'Interesada en el área de desarrollo web y bases de datos.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Carlos Muñoz Rivas',
                'email'      => 'carlos.munoz@example.cl',
                'carrera'    => 'Ing. Comercial',
                'mensaje'    => 'Enfocado en sistemas de información empresarial.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre'     => 'Valentina Torres Silva',
                'email'      => 'valentina.torres@example.cl',
                'carrera'    => 'Otro',
                'mensaje'    => 'Estudiante de intercambio, explorando tecnologías web.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Productos (Módulo 2)
        Producto::insert([
            [
                'nombre_producto' => 'Laptop HP 15"',
                'precio'          => 599990.00,
                'stock'           => 12,
                'categoria'       => 'electronico',
                'descripcion'     => 'Procesador Intel Core i5, 8GB RAM, 256GB SSD.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'nombre_producto' => 'Polera Corporativa',
                'precio'          => 12990.00,
                'stock'           => 50,
                'categoria'       => 'ropa',
                'descripcion'     => 'Polera con logo institucional, varios colores.',
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
            [
                'nombre_producto' => 'Mouse Inalámbrico',
                'precio'          => 18990.00,
                'stock'           => 30,
                'categoria'       => 'electronico',
                'descripcion'     => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);

        // Contactos universitarios (Módulo 3)
        Contacto::insert([
            [
                'nombre_completo'      => 'Prof. Roberto Sánchez',
                'correo_institucional' => 'rsanchez@unach.cl',
                'asunto'               => 'Consulta sobre sala de cómputo',
                'prioridad'            => 'media',
                'descripcion'          => 'Necesito reservar la sala B para clases de laboratorio el próximo mes.',
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'nombre_completo'      => 'Marcela Fuentes Díaz',
                'correo_institucional' => 'mfuentes@adventista.cl',
                'asunto'               => 'Problema con acceso al sistema',
                'prioridad'            => 'alta',
                'descripcion'          => 'No puedo ingresar al portal estudiantil desde hace dos días. Mi usuario es mfuentes.',
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'nombre_completo'      => 'Pedro Herrera Campos',
                'correo_institucional' => 'pedro.herrera@unach.cl',
                'asunto'               => 'Solicitud de certificado',
                'prioridad'            => 'baja',
                'descripcion'          => 'Requiero certificado de alumno regular para postular a una beca de estudio.',
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
        ]);

        // Solicitudes de soporte TI (Módulo 4)
        SolicitudSoporte::insert([
            [
                'solicitante'          => 'Dra. Patricia Vega',
                'email_contacto'       => 'pvega@unach.cl',
                'tipo_incidente'       => 'software',
                'descripcion_problema' => 'El sistema de gestión académica no carga en mi equipo. Aparece error 500 al intentar ingresar.',
                'urgencia'             => 'alta',
                'equipo_afectado'      => 'PC escritorio Lab A-12',
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'solicitante'          => 'Ing. Luis Contreras',
                'email_contacto'       => 'lcontreras@adventista.cl',
                'tipo_incidente'       => 'red',
                'descripcion_problema' => 'No hay conexión a internet en el pabellón C. Los equipos muestran "sin acceso a la red" desde las 8 AM.',
                'urgencia'             => 'critica',
                'equipo_afectado'      => 'Pabellón C — todos los equipos',
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'solicitante'          => 'Claudia Morales',
                'email_contacto'       => 'cmorales@unach.cl',
                'tipo_incidente'       => 'hardware',
                'descripcion_problema' => 'El proyector de la sala 201 no enciende. Lo he revisado y el cable de alimentación está bien conectado.',
                'urgencia'             => 'media',
                'equipo_afectado'      => 'Proyector Sala 201',
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
        ]);
    }
}
