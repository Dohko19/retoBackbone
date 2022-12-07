# retoBackbone
 Zip codes API 
# Como aborde el problema
Primero empece descargando todos los zipcodes en formato Excel, los pase a formato CSV con separador de "|"
2. Instale paquete para importar archivos excel, elimine el primer libro de dicho excel ya que no era de utilidad
3. Cree la ruta con el controlador mas la respectiva migracion y modelo llamado: Location
4. Mediante eloquent busque el codigo postal que se requeria
5. Recorri la coleccion de resultado y la separe por arrays para al final hacer un merge de dichos arrays
6. Despues regrese el resultado en JSON como lo requeria la API
