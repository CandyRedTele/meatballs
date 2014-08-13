import java.io.File;
import java.io.FileNotFoundException;
import java.io.PrintStream;
import java.util.ArrayList;
import java.util.Scanner;

/**
creates a gen_admins.sql file based on the staffgen.sql file that you select from commandline params.
DO NO EDIT UNLESS YOU ARE GEOFFREY
*/
public class generate_data {
	final static int numBills = 300;
	public static void main(String[] args) throws FileNotFoundException {
		//Scanner keyin = new Scanner(System.in);
		//System.out.println("Where is the staff file located?");
		//String staffloc = keyin.next();
		
		//String staffloc = "staffgen.sql";
		
		String folder = "output"+ File.separator;
        boolean genbills = false;
        boolean genstaff = false;
		String staffloc = "";
                
		if(args.length == 0){
			System.out.println("command line input required");
            System.exit(1);
        }
        if(args.length == 1){
            if(args[0].equals("bill")){
            	genbills = true;
            }
            else{
	            staffloc = args[0];
	            System.out.println("scanning from " + args[0]);
            }
        }

        if(args.length == 2){
            if(args[0].equals("bills")){
            	genbills = true;
            }
            else if(args[0].equals("staff")){
            	genstaff = true;
                staffloc = args[1];

            }
            else if(args[0].equals("all")){
            	genbills = true;
            	genstaff = true;
                staffloc = args[1];
            }
            else{
            	System.out.println("input invalid, exiting");
            	System.exit(1);
            }
        }

        PrintStream p = System.out;
        if(genstaff){
			p = new PrintStream(folder + "gen_admin.sql");
	        File staff = new File(staffloc);
			Scanner staff_reader = new Scanner(staff);
			
			gen_admins(staff_reader,p);
	        
			p = new PrintStream(folder + "gen_localStaff.sql");
			staff = new File(staffloc);
			staff_reader = new Scanner(staff);
			
			gen_localstaff(staff_reader, p);
			
			p = new PrintStream(folder + "gen_access_level.sql");
			gen_access_level(p);
        }
		
        if(genbills){
			p = new PrintStream(folder +"gen_bills.sql");
			PrintStream p2 = new PrintStream(folder + "gen_bill_has_items.sql");
			gen_bills(p, p2);
			
			
			p = new PrintStream(folder + "gen_golden_bills.sql");
			gen_golden_bills(p);
        }
		

	}
	
	private static void gen_access_level(PrintStream p){
		String name = "access_level";
		String[] fields = {"title", "access_level"};
		ArrayList<Object> access_level = new ArrayList<Object>();
		
		access_level.add(new Object[] {"'ceo'", 1});
		access_level.add(new Object[] {"'cto'", 1});
		access_level.add(new Object[] {"'cfo'",  1});
		access_level.add(new Object[] {"'human resources'", 1});
		access_level.add(new Object[] {"'accounting'", 2});
		access_level.add(new Object[] {"'marketing'", 2});
		access_level.add(new Object[] {"'manager'", 3});
		access_level.add(new Object[] {"'chef'", 4});
		//access_level.add(new Object[] {"'shift supervisor'", 5});
		access_level.add(new Object[] {"'delivery personnel'", 6});
		access_level.add(new Object[] {"'dishwasher'", 6});
		access_level.add(new Object[] {"'wait staff'", 6});


		gen_data(name, fields, access_level.toArray(), p);

	}
	
	private static void gen_localstaff(Scanner staff_reader, PrintStream p) {
		
		String name = "localstaff";
		String[] years = {"2012", "2013", "2014"};
		String[] fields = {"start_date", "f_id", "staff_id"};
		
		ArrayList<Object> localStaffs = new ArrayList<Object>();
		
		for(int i = 1; staff_reader.hasNext(); i++){
			
			String nextLine = staff_reader.nextLine();
			if(!(nextLine .contains("ceo")
					||nextLine.contains("cfo")
					||nextLine.contains("cto")
					||nextLine.contains("use meatballs"))
					&& nextLine.contains(";")
					){
				Object[] localStaff = {"'" + years[i%years.length] + "-" +((i*23)% 12+1)+ "-" + ((i*27)% 29+1) + "'",
						((i*29)% 12+1), 
						i};
				
				localStaffs.add(localStaff);	
			}
			if (nextLine.contains("use meatballs")){
				i--;
			}
			
		}
		gen_data(name, fields, localStaffs.toArray(), p);
		
		
	}
	
	static void gen_golden_bills(PrintStream p){
		
		String[] fields = {"g_id", "b_id"};
		String name = "golden_has_bills";
		ArrayList<Object> golden_bills = new ArrayList<Object>();
		
		
		for(int i = 1; i < numBills/2; i++){
			
			Object[] golden_bill = {((i * 101)%30+1), i};
			golden_bills.add(golden_bill);
			
		}
		gen_data(name, fields, golden_bills.toArray(), p);
		
	}

	static void gen_admins(Scanner staff_reader, PrintStream p){
		
		String name = "admin";
		String[] locations = {"Montreal", "Toronto", "Winipeg", "Narnia", "Calgary", "Faraway", "Halifax", "Ottowa", "Vancouver", "Regina", "Quebec", "Sherbrooke"};
		
		String[] fields = {"staff_id", "location", "yrs_exp"};
		
		ArrayList<Object> admins = new ArrayList<Object>();

		
		for(int i = 1; staff_reader.hasNext(); i++){
			String nextLine = staff_reader.nextLine();
			if ((nextLine.contains("ceo") 
					||nextLine.contains("cfo") 
					||nextLine.contains("cto"))
					&& nextLine.contains(";")
					){
				
				Object[] admin = {i, "'" + locations[i%locations.length] + "'", i%5};
				admins.add(admin);

			}
			if (nextLine.contains("use meatballs")){
				i--;
			}
		}
		gen_data(name, fields, admins.toArray(), p );
		
	}
	
	static void gen_bills(PrintStream p1, PrintStream p2){
		String[] years = {"2012", "2013", "2014"};
		String[] fields = {"f_id", "date"};
		String name = "bill";
		String[] fields_has_item = {"b_id", "mitem_id"};
		String item_name = "bill_has_menu_item";
		
		ArrayList<Object> bills = new ArrayList<Object>();
		ArrayList<Object> has_items = new ArrayList<Object>();
		for(int i = 0; i < numBills;i++){
			
			Object[] bill = {((i*29)%12+1),
					"'" + years[i%years.length] + "-" + ((i*23)% 12+1) + "-" + ((i*27)% 29+1) + "'"
			};
			bills.add(bill);
			
			for(int jay = 1; jay < 5; jay++){
				Object[] has_item = {(i + 1),
						(i * 101 % 80 + 1)
				};
				has_items.add(has_item);
			}
			
		}
		gen_data(name, fields, bills.toArray(), p1);
		gen_data(item_name, fields_has_item, has_items.toArray(), p2);
	}
	


	
	static void gen_data(String table, String[] fields, Object[] values, PrintStream p){
		p.println("use meatballs;");
		p.print("insert into " + table + " (" );
		for (int i = 0; i < fields.length; i++){
			p.print(" " + fields[i] + "");
			if(i != fields.length-1){
				p.print(", ");
			}
		}
		p.println(") Values");
		
		for(int eye = 0; eye < values.length; eye++){
			p.print("(");
			Object[] value = (Object[]) values[eye];
			for(int jay = 0; jay < value.length; jay++){
				p.print(value[jay]);
				//print the commas between values
				if(jay != value.length-1){
					p.print(", ");
				}
				//print the bracket after all the values
				else{
					p.print(")");
				}
			}
			//print the comma after a list of values
			if(eye != values.length-1){
				p.println(",");
			}
		}
		p.print(";");
	}
}
