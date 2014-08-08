import java.util.Scanner;
import java.io.File;
import java.io.PrintWriter;
import java.io.IOException;

public class listNames{

    public static void main(String[] args) throws IOException{

        String[][] names = listNames();

        String[][] r = getRandomN(100,names);

        printAll(r);

    }

    public static void printAll(String[][] names){
        for(int i = 0; i < names.length; i++){

            System.out.println(names[i][0] + ", " + names[i][1]);

        }
    }

    public static String[][] getRandomN(int n, String[][] names){
        

        String[][] tempName = new String[n][2];
        
        for(int i = 0; i < n ; i++){
            
            int random = (int) (Math.random()*names.length);
            tempName[i] = names[random];
            //System.out.println(names[i][0] + ", " + names[i][1]);
            
        }

        return tempName;
        
    }
        

    public static String[][] listNames() throws IOException{
        
        File in = new File("ListOfNames");

        Scanner scan = new Scanner(in);

        int count = 0;
        while(scan.hasNext()){

            String nextLine = scan.nextLine();
            if(nextLine.contains(", ") && !nextLine.contains("(")){
                String[] name = nextLine.split(", ");
                if(!(name[0].contains(" ") || name[1].contains(" ")))
                    count++;
            }
        }

        //System.out.println(count);

        String[][] names = new String[count][2];

        scan = new Scanner(in);

        int i = 0;
        while(scan.hasNext()){
            
            String nextLine = scan.nextLine();
            
            if(nextLine.contains(", ") && !nextLine.contains("(")){

                String[] name = nextLine.split(", ");

                //System.out.println( "last name: " + name[0] + ", first name: " + name[1]);
                if(!(name[0].contains(" ") || name[1].contains(" "))){

                    names[i] = name;
                    
                    i++;

                }

            }

        }

        return names;

    }

}

        
