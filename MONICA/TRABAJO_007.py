import copy
print("---EJERCICIO 1: Copia de Listas  ---")
#Lista de inventario: [Producto, [Cantidad, Precio]]
inventario_original = ["Tablet", [10, 800]]
#1. hacemos una copia superficial
copia_superficial = copy.copy(inventario_original)

#2. hacemos una copia profunda
copia_profunda = copy.deepcopy(inventario_original)

#3. Simulamos una venta de las copias
print(f"Original antes: {inventario_original}")
#Modificamos la cantidad en la copia superficial
copia_superficial[1][0] = 5

#Modificamos la cantidad en la copia profunda
copia_profunda[1][0] = 5

#Modfificamos la cantidad en la copia_profunda
copia_profunda[1][0] = 0


print("Copia superficial: ", copia_superficial)
print("Copia profunda: ", copia_profunda)
print(f"Copia superficial despues: {copia_superficial}")
print(f"Copia profunda despues: {copia_profunda}")
print(f"Original despues: {inventario_original}")
print("\nOBSERVACION: El original cambió a 5 por culpa de la copia")

#\n salto de lineaprint("-- EJERCICIO 2 : Tuplas vs Listas")
 #Lista de tareas (Mutable)
tareas = ["Estudiar", "Comprar leche", "Comprar pan"]

tareas[1]= "programa" 
print(f"Lista modificada:{tareas}")
 
 #Coordenadas GPS Inmutables - Tuplas
coordenadas = (40.7128, 74.0060)
 
try:
   print("Intentando modificar la latitud de la tupla ...")   
   coordenadas[0] = 41.0
except TypeError as e:
   print(f"ERROR CAPTURADO: {e}")
 
   print("VISUAL CODE TE AVISARÁ DE ESTO : LAS TUPLAS NO SE TOCAN")
 
#crear un decorador que nos avise automaticamente cada vez que una función se ejecuta, sin tocar el código de la función
print("EJERCICIO 3: DECORADOR")
def mi_chivato(funcion):
    def envoltura(*args, **kwargs):
        print("Estoy ejecutando la función {}".format(funcion.__name__))
        resultado = funcion(*args, **kwargs)
        print("He terminado de ejecutar la función {}".format(funcion.__name__))
        return resultado
    return envoltura

# usamos el decorador con @
@mi_chivato
def suma_pesada(a, b):
    return a + bimport pandas as pd

print("\n--EJERCICIO 4: Pandas básico--")

datos = {
    "Alumno": ["Ana", "Pedro", "Carlos", "Maria"],
    "Nota": [8.5, 4.0, 9.2, 6.5],
    "Aprobado": [True, False, True, True]
}
df = pd.DataFrame(datos)
print("----Tabla de Notas")
print(df)

print("\n --Alumnos Destacados (< 8)----")
destacados = df[df["Nota"] < 8]
print(destacados)

promedio = df['Nota'].mean()
print(f"\nNota media de la clase: {promedio}")
@mi_chivato
def saludar(nombre):
    print(f"Hola {nombre}")
#probamos
x = suma_pesada(10 , 20)
print(f"El resultado de la suma es: {x}")

saludar("Estudiante")
