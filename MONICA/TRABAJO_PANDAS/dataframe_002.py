
import pandas as pd

# reutilizamos el ejercicio anterior
data = {
    "Comerciales": ["Ana", "Ana", "Ana", "Luis", "Luis", "Luis", "Marta", "Marta", "Marta"],
    "Mes": ["Ene", "Feb", "Mar", "Ene", "Feb", "Mar", "Ene", "Feb", "Mar"],
    "Ventas": [1000, 1200, 1100, 900, 950, 1000, 1300, 1250, 1400]
}

df = pd.DataFrame(data)
#creamos un filtrado booleanno para ventas > 1100 y lo guardamos en una variable y lo imprimimos
    
df_filtrado = df[df["Ventas"] > 1100] 
print(df_filtrado)  
print("\n")

#filtrado solo las filas de "Ana" y muestra solo Mes y Ventas y lo imprimimos (las mayores de 1100, que es el filtrado anterior)

df_filtrado = df[(df["Comerciales"] == "Ana") & (df["Ventas"] > 1100)][["Mes", "Ventas"]]
print(df_filtrado)  
print("\n")