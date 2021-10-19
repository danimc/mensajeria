export class Articulo {
	public tipo: number
	public marca: number
	public modelo: number
	public nSerie: string

	constructor(tipo_: number,marca_: number, modelo_ : number, public nSerie_: string){
		this.nSerie = nSerie_;
		this.tipo = tipo_;
		this.marca = marca_;
		this.modelo = modelo_;
	}


}

