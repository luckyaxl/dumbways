public class Diamonds {
    public static void main(String[] args) {
       int totalStars = 9;
       int rows = 9;
   
       for (int r = 0,stars=-1,gap=totalStars; r < rows; r++   ) {
           stars+= (r<=rows/2) ?2:-2;
           gap=totalStars-stars;
   
           printChars(' ', gap);
           printChars('*', stars);
           printChars(' ', gap);
           int gap2=stars+1;
           int stars2=gap+1;
           printChars(' ', gap2);
           printChars('*', stars2);
           printChars(' ', gap2);
           System.out.println();
       }
    }
   
    private static void printChars(char c ,int times) {
       for (int i = 0; i < times; i++) {
           System.out.print(c);
       }
    }
   }