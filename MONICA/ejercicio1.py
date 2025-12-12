
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
print("\nOBSERVACION: El original cambió a 5 por culpa de la copia")#\n salto de linea
