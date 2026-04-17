import json
from datetime import datetime

# 📂 Función para cargar el JSON
def cargar_usuarios():
    try:
        with open("usuarios.json", "r") as archivo:
            datos = json.load(archivo)  # 👈 se usa json correctamente
            return datos
    except FileNotFoundError:
        print("ERROR: No se encontró el archivo usuarios.json")
        return []
    except json.JSONDecodeError:
        print("ERROR: El archivo JSON está mal formado")
        return []

# 🔍 Buscar usuario por ID
def buscar_usuario(usuarios, id_ingresado):
    for usuario in usuarios:
        if usuario["id_tarjeta"] == id_ingresado:
            return usuario
    return None

# 📝 Guardar en log
def registrar_log(mensaje):
    with open("auditoria.txt", "a") as archivo:  # 👈 modo append
        fecha_hora = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        archivo.write(f"{fecha_hora} - {mensaje}\n")

# 🚀 Programa principal
def main():
    usuarios = cargar_usuarios()
    
    if not usuarios:
        return
    
    while True:
        print("\n--- CONTROL DE ACCESO ---")
        id_ingresado = input("Ingresa ID de tarjeta (o escribe 'salir'): ")

        if id_ingresado.lower() == "salir":
            print("Sistema finalizado.")
            break

        usuario = buscar_usuario(usuarios, id_ingresado)

        if usuario:
            print("CERRADURA ABIERTA por 5 segundos")
            mensaje = f"ACCESO PERMITIDO - ID: {id_ingresado} - {usuario['nombre_empleado']}"
        else:
            print("ALARMA ACTIVADA - Intento de acceso no autorizado")
            mensaje = f"ACCESO DENEGADO - ID: {id_ingresado}"

        registrar_log(mensaje)

# ▶️ Ejecutar programa
if __name__ == "__main__":
    main()