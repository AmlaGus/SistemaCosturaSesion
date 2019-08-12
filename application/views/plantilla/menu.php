<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Costurería Fernández</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php base_url()?>Administrador/registrarEmpleado">Trabajadores</a>
            </li>
        </ul>


        <form class="form-inline my-2 my-lg-0">
           <ul class="navbar-nav mr-auto"> <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Perfil
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Configuración</a>
                    <a class="dropdown-item" href="<?php echo base_url('Administrador/logout')?>">Cerrar Sesión</a>

                </div>
            </li></ul>
        </form>
    </div>
</nav>

<?php $this->load->view('plantilla/footer')?>