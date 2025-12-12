# Crea un Dataframe con las ventas mensuales de 3 comerciales(Ana,Luis, Marta)durante el trimestre de Ene-Feb-Mar.
# Requisistos:
# Columnas Comercial, Mes; Ventas.
# Muestra las primeras filas son : head()
# Obtén informaciń del DataFrame.com: info()
#Calcula estadistícas descriptivas con: describe()
# Datos Ana:Ene=1000, Feb=1200, Mar=1100
# Datos Luis:Ene=900, Feb=950, Mar=1000
# Datos Marta:Ene=1300, Feb=1250, Mar=1400  

import pandas as pd

data = {
    "Comerciales": ["Ana", "Ana", "Ana", "Luis", "Luis", "Luis", "Marta", "Marta", "Marta"],
    "Mes": ["Ene", "Feb", "Mar", "Ene", "Feb", "Mar", "Ene", "Feb", "Mar"],
    "Ventas": [1000, 1200, 1100, 900, 950, 1000, 1300, 1250, 1400]
}

df = pd.DataFrame(data)
print("Primeras filas")
print(df.head())
print("\nInformación del DataFrame")
print("df.info()")
print(df.info())
print("\nEstadísticas descriptivas")
print("df.describe()")
print(df.describe())