
public class StaffMember {
	final int staff_id;
	final String name;
	final String title;
	final String streetname;
	final String phonenumber;
	final String ssn;
	int f_id;
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
	
	public String toString(){
		String fd = "";
		if(f_id != 0){
			fd = new Integer(f_id).toString();
		}
		return staff_id + ", " + name + ", " + title; 
	}
	/*
	i, 
	"'" + gen_name(3)+"'",
	"'" + streetnames[random_num(0, streetnames.length-1)]+ "'", 
	"'" + gen_phone() + "'", "'" + gen_SSN() + "'", "'" + title + "'"
	*/
}
