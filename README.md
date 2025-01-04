# Proyecto 4VGym

Este proyecto es una aplicación web que permite gestionar actividades de un gimnasio. Ofrece una interfaz interactiva para visualizar, agregar, editar y eliminar actividades.

---

## Archivos Esenciales del Proyecto

### Archivos principales:
1. **`index.php`**:
   - Es el corazón del proyecto.
   - Realiza la conexión con la base de datos y gestiona las acciones principales: agregar, editar y eliminar actividades.
   - **Importante**: Asegúrate de configurar correctamente las credenciales de la base de datos.

2. **`actividades.php`**:
   - Gestiona las operaciones relacionadas con las actividades.
   - Está vinculado al funcionamiento dinámico del proyecto.

3. **`insert.html`**:
   - Formulario utilizado para agregar nuevas actividades al sistema.

4. **Base de datos**:
   - Necesitas una base de datos MySQL llamada `4VGym` para que el proyecto funcione.
   - **Nota**: Crea la base de datos y asegúrate de que las tablas necesarias estén configuradas correctamente.

### Archivos adicionales:
- **`index.html`**:
  - Una página estática que no es imprescindible, pero puede ser útil para navegar.
- **Carpeta `assets/`**:
  - Contiene imágenes y otros recursos estáticos. No afecta directamente el funcionamiento del sistema.
- **Archivos de Git (`.git/`)**:
  - Relacionados con el control de versiones. No afectan el código.

---

## Requisitos del Sistema

- **Servidor web**: Apache, Nginx o similar.
- **PHP**: Versión 7.4 o superior.
- **Base de datos**: MySQL o MariaDB.
- **Navegador web**: Compatible con los navegadores modernos.

---

## Instalación y Ejecución

### Paso 1: Clonar el repositorio
Clona el repositorio en tu servidor local:
```bash
git clone <URL_DEL_REPOSITORIO>
cd recu_iaw
