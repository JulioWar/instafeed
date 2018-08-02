## Explicacion de la Clase Model
La configuracion de la base de datos ahora se encuentra en el archivo `/configs/database.php`. Si la configuracion de nombre de base de datos, 
usuario o contraseña es diferentes, ese sería el lugar donde cambiarlo.

### Metodos
Todas las clases que extiendan de la clase `Model` tendran las siguientes metodos disponibles.

#### Metodo `query`
Se utiliza para iniciar una consulta a la base de datos. Retorna una
**Ejemplo:**
```php
  User::query()->get();
```

#### Metodo `get`
Este metodo ejecuta la consulta y devuelve un arreglo de los datos obtenidos de la base de datos.
**Ejemplo:**
```php
User::query()->where('username', 'like', '%jul%')->get();
```

#### Metodo `where`
Este metodo agrega un filtro a la consulta por medio de un WHERE de SQL. 
Esta función posee tres parametros, los cuales se describen a continuación:
**Ejemplo:**
```php
/**
 * Primer Parametro: Nombre de la columna
 * Segundo Parametro: Operador de Comparacion
 * Tercer Parametro: Valor a Comparar.
 */
$usuarios = User::query()->where('username', 'like', '%jul%')->get();
```

#### Metodo `count`
Este metodo se utiliza en vez del metodo `get`. Devuelve el numero de filas de la consulta.
**Ejemplo:**
```php
$numeroUsuarios = User::query()->count();
```



| Metodo  | Tipo | Parametros | Descripción |
|---------|------|------------|-------------|
| `query` | **Estatica** |  |Se utiliza para iniciar una consulta a la base de datos.
