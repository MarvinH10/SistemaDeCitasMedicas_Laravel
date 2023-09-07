<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
  <div class=" dropdown-header noti-title">
    <h6 class="text-overflow m-0">Bienvenido!</h6>
  </div>
  <a href="#" class="dropdown-item">
    <i class="ni ni-single-02"></i>
    <span>Mi perfil</span>
  </a>
  <a href="#" class="dropdown-item">
    <i class="ni ni-settings-gear-65"></i>
    <span>Configuración</span>
  </a>
  <a href="./examples/profile.html" class="dropdown-item">
    <i class="ni ni-calendar-grid-58"></i>
    <span>Mis citas</span>
  </a>
  <a href="./examples/profile.html" class="dropdown-item">
    <i class="ni ni-support-16"></i>
    <span>Ayuda</span>
  </a>
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
    <i class="fas fa-door-open"></i>
    <span>Cerrar sesión</span>
    <form action="{{ route('logout') }}" method="POST" style="display: none;" id="formLogout">
        @csrf
    </form>
  </a>
</div>
