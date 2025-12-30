<!DOCTYPE html>
<html lang="en">

<style>
.color-activar {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
</style>

<body>
    <div>
        <table border="1" cellpadding="2" cellspacing="2" style="100%">
            <tr>
                <td style="background: white;" width="100%" colspan="2">
                    <h2 align="center"><img align="center" width="70px" height="70px";
                            src="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/06/LOGO-PAGINA-WEB.png"></h2>
                    <h2 align="center">Empresa Pública Municipal Movilidad de Manta-EP</h2>
                </td>
            </tr>
            <tr>
                <td align="left" width="100%">
                    @foreach($json_data as $data)
                    <table>
                        <tr>
                            <td><strong>Apellidos y Nombres:</strong></td>
                            <td>{{$data->emp_apellido}} {{$data->emp_nombre}}</td>
                        </tr>
                        <tr>
                            <td><strong>Jefatura:</strong></td>
                            <td>{{$data->dep_departamento}}</td>
                        </tr>
                    </table>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>
</body>

</html>