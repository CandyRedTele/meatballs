
public class StaffMember {
	final int staff_id;
	final String name;
	final String title;
	final String streetname;
	final String phonenumber;
	final String ssn;
	String training;
	int f_id;
	
	String start_date;
	
	//for admins
	String location;
	
	int yrs_exp;
	
	Shift[] Shifts;

	public StaffMember(int staff_id, String name, String streetname, 
			String phonenumber, String ssn, String title){
		
		this.staff_id = staff_id;
		this.name = name;
		this.streetname = streetname;
		this.phonenumber = phonenumber;
		this.ssn = ssn;
		this.title = title;
		
	}
	public void addF_id(int f_id){
		this.f_id = f_id;
	}
	public void addShifts(Shift[] shifts){
		this.Shifts = shifts;
	}
	public void addTraining(String training){
		this.training = training;
	}
	
	public String toString(){
		String fd = "";
		if(f_id != 0){
			fd = new Integer(f_id).toString();
		}
		return staff_id + ", " + name + ", " + title + "," + fd; 
	}
	
}
