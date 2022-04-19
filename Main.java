abstract class Mamalia{
	protected String nama;
	protected double selang;
	abstract public double melahirkan();
	public void cetak(){
 		System.out.println("Jenis "+nama);
 		System.out.println("Melahirkan dalam " + melahirkan());
 	}
}
class Paus extends Mamalia{
  Paus(String namaa, double selangg)
  {
    nama = namaa;
    selang = selangg;
  }

 	public double melahirkan(){
		return selang / 60;
	}
}
// class Beruang extends Mamalia{
//  	public void setNama(String Nama ){
// 		nama = Nama;
// 	}
// }
public class Main{
	public static void main(String [] args){
		Paus a = new Paus("Paus orca", 30);
		a.cetak();
	}
}