<?php

class Regalo {

    public function __construct(public string $name, public int $peso) {
        
    }

}

class BolsaDePapaNoel {

    public $bolsa = array();
    private $ordenado = false;

    const PESO_MAXIMO = 5000;

    public function agregarRegalo(Regalo $regalo): void {

        $this->comprobarPeso($regalo);
        $this->comprobarExistencia($regalo);
        $this->bolsa[] = $regalo;
        $this->ordernar_pesado();
    }

    private function comprobarExistencia(Regalo $regalo): void {
        $this->yaExiste($regalo)?throw new Exception("El regalo ya fue agregado"):null;
    }

    private function comprobarPeso(Regalo $regalo): void {
        /* calculo el peso actual y le sumo el peso del regalo entrante
          esto lo hago asi para no agegar el regalo antes de la comprobacion. */
        (($this->pesoActual() + $regalo->peso) > self::PESO_MAXIMO)?throw new Exception("La bolsa no puede contener mas de 5000 gramos"):null;
    }

    private function ordernar_pesado(): array {

        /* hago una copia del array para no modificar el de la clase */
        $bolsa = $this->bolsa;
        /* Ordeno de mas peso a menos peso para luego tomar la primera posicion. */
        usort($bolsa, fn($anterior, $posterior) =>
                $posterior->peso <=> $anterior->peso
        );
        return $bolsa;
    }

    public function yaExiste(Regalo $regalo): bool {
        return in_array($regalo, $this->bolsa);
    }

    public function pesoActual(): int {
        /* sumatoria de todos los pesos */
        /* PD: los pesos deberian ser flotantes, pero en el test estan como enteros. */
        return intval(
                array_reduce($this->bolsa, fn(mixed $carry, Regalo $regalo): int =>
                        intval($carry) + intval($regalo->peso)
                )
        );

//       $array;
    }

    public function regaloMasPesado(): string {
        /* Luego de ordenar el primero es el mas pesado. */
        return $this->ordernar_pesado()[0]->name;
    }

}
