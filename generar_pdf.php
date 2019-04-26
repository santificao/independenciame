<?php
require('PDF/fpdf.php');
require("modelo/db_abstract_model.php");
require("modelo/modelo_usuario.php");
require("modelo/modelo_trabajador.php");
require("modelo/modelo_paciente.php");

class PDF extends FPDF
{
        // Cabecera de página
    function Header()
    {
            // Arial bold 15
        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(19,54,53);

            // Título
        $this->Image('PDF/titulo.jpg' , 60 , 12, 'JPG', '');
    
        // Salto de línea
        $this->Ln(5);
        $this->Cell(0, 0, '- nueva solicitud -', 0, 1, "C");//El 0 de ancho de la celda es para que coja todo el ancho de la página
    }
        
        // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 15);
        $this->SetLineWidth(0.4);
        $this->SetDrawColor(50,50,50);
        $this->Cell(0,10,"","T",0,0);
        $this->SetX(20);
        $this->SetTextColor(19,54,53);
        $this->SetFont("Arial","B",9);
        $this->Cell(0, 10, "- Indepénciame - Todos los derechos reservados", 0, 0, "R");
    }
}


// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->setMargins(20, 30, 20);
$pdf->AddPage();

$usuario = new Usuario();
$usuario->get_usuario_por_id($_GET["id"]);

switch($usuario->tipo_usuario) {
    case 'B': $tipo_usuario = 'Asistente';
        break;
    case 'C': $tipo_usuario = 'Paciente';
        break;
}

switch($usuario->tipo_usuario) {
    case 'B': 
        $trabajador = new Trabajador();
        $trabajador->datos_trabajador($_GET["id"]);
        $tipo = $trabajador->tipo_trabajador;
        switch($tipo) {
            case 1:
                $tipo = "Voluntario";
                break;
            case 2:
                $tipo = "Trabajador";
                break;
        }
        break;
    case 'C': 
        $paciente = new Paciente();
        $paciente->datos_paciente($_GET["id"]);
        $tipo = $paciente->grado_dependencia;
        switch($tipo) {
            case 1:
                $tipo = "Dependencia moderada";
                break;
            case 2:
                $tipo = "Dependencia severa";
                break;
            case 3:
                $tipo = "Gran dependencia";
                break;
        }
        break;
}

$pdf->SetTextColor(19,54,53);
$pdf->SetFont('Arial', 'B', 13);
$y = $pdf->GetY();
$pdf->SetY($y+15);
$pdf->Cell(0, 7, 'Datos personales:', 0, 1, "L");

$pdf->SetTextColor(19, 19, 19);
$pdf->SetFont('Times', '', 12);

$pdf->Cell(0, 7, 'Nombre: '.$usuario->nombre, 0, 1, "L");
$pdf->Cell(0, 7, 'Primer apellido: '.$usuario->apellido_1, 0, 1, "L");
$pdf->Cell(0, 7, 'Segundo apellido: '.$usuario->apellido_2, 0, 1, "L");
$pdf->Cell(0, 7, 'Dni: '.$usuario->dni, 0, 1, "L");
$pdf->Cell(0, 7, 'Fecha de nacimiento: '.$usuario->fecha_nacimiento, 0, 1, "L");
$pdf->Cell(0, 7, 'Teléfono: '.$usuario->telefono, 0, 1, "L");
$pdf->Cell(0, 7, 'Email: '.$usuario->email, 0, 1, "L");

$y = $pdf->GetY();
$pdf->SetY($y+15);

$pdf->SetTextColor(19,54,53);
$pdf->SetFont('Arial', 'B', 13);

$pdf->Cell(0, 7, 'Datos de la cuenta:', 0, 1, "L");
$pdf->SetTextColor(19, 19, 19);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(0, 7, 'Ciudad: '.$usuario->ciudad, 0, 1, "L");
$pdf->Cell(0, 7, 'Dirección: '.$usuario->direccion, 0, 1, "L");
$pdf->Cell(0, 7, 'Tipo de cuenta: '.$tipo_usuario, 0, 1, "L");
$pdf->Cell(0, 7, 'Tipo de usuario: '.$tipo, 0, 1, "L");




$pdf->Output();

?>