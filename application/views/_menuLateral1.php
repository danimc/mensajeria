<?
$codigo = $this->session->userdata("codigo");
$usuario = $this->m_usuario->obt_usuario($codigo);
?>

<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">

        <ul class="side-menu metismenu">
            <li class="heading">MENÚ LATERAL</li>
            <li class="active">
                <a href="<?php echo base_url(); ?>inicio">
                    <i class="sidebar-item-icon ti-home"></i>
                    <span class="nav-label">Inicio</span></a>
            </li>
            <li>
                <a href="<?php echo base_url() ?>mensajeria/nueva_copia">
                    <i class="sidebar-item-icon ti-desktop"></i>
                    <span class="nav-label">Control de Oficios</span><i class="fa fa-angle-left arrow"></i></a>
                <ul class="nav-2-level collapse">
                    <li>
                        <a href="<?php echo base_url(); ?>oficios/nuevaCaptura"><i class="sidebar-item-icon ti-plus"></i> <span>Nuevo Oficio</span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>oficios"><i class="sidebar-item-icon fa ti-files"></i> <span>Libro Oficios</span></a>
                    </li>
                </ul>
            </li>

        </ul>
        <div class="sidebar-footer">
            <!--                     <a href="javascript:;"><i class="ti-announcement"></i></a>
                    <a href="calendar.html"><i class="ti-calendar"></i></a>
                    <a href="javascript:;"><i class="ti-comments"></i></a> -->
            <a href="<?= base_url() ?>index.php?/acceso/logout" title="Cerrar Sesion"><i class="ti-power-off"></i></a>
        </div>
    </div>
</nav>