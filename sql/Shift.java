public class Shift{
	


	static final int cook = 0;
	static final int dish = 1;
	static final int wait = 2;
	int[] taken = new int[3];
	public int start;
	public int end;
	public int day;
	String title;
	public final String[] days = {
		"Monday",
		"Tuesday",
		"Wednesday",
		"Thursday",
		"Friday", 
		"Saturday",
		"Sunday"
	};
	
	final int shifthours[] = {
			8,
			8,
			6
	};
	
	public Shift(int start, int type, int day){
		
		if(type == cook){
			title = "cook";
		}
		if(type == dish){
			title = "dishwasher";
		}
		if(type == wait){
			title = "wait staff";
		}
		
		//hour at which they begin their shift
		int begin_day = 11;
		
		//if they are cooks or dish-washers
		if(type == 0 || type == 1){
			begin_day = 7;
		}
		if(start == 0){
			start = begin_day;
		}
		if(start == 1){
			start = begin_day+shifthours[type];
		}
		
		this.start = start;
		this.end = start + shifthours[type];
		this.day = day;
	}
	
	public Shift take(int staff_id){
		for(int i = 0; i < taken.length; i++){
			if(taken[i] == staff_id){
				System.out.println("Shift take rejected. Staff #" + staff_id 
						+ "is already doing Shift");
				return null;
			}
			if(taken[i] == 0){
				taken[i] = staff_id;
				return this;
			}
		}
		System.out.println("Shift take rejected. Staff #" + staff_id 
				+ "shift is already full");
		return null;
	}
	
	public boolean canTake(int staff_id){
		for(int i = 0; i < taken.length; i++){
			if(taken[i] == staff_id){
				if (generate_data.debug)
					System.out.println("Shift cannot be taken. Staff #" + staff_id 
						+ "is already doing Shift");
				return false;
			}
			if(taken[i] == 0){
				return true;
			}
		}
		if(generate_data.debug)
			System.out.println("Shift cannot be taken. Staff #" + staff_id 
				+ "shift is already full");
		return false;
	}
	
	public String toString(){
		return("start, " + start + " end, " + end + " day, " + days[day]);
	}
	
	
	//show columns from shift;
	//+------------+------------+------+-----+---------+-------+
	//| Field      | Type       | Null | Key | Default | Extra |
	//+------------+------------+------+-----+---------+-------+
	//| staff_id   | int(11)    | NO   | PRI | NULL    |       |
	//| date       | date       | NO   | PRI | NULL    |       |
	//| time_start | time       | NO   | PRI | NULL    |       |
	//| time_end   | time       | NO   |     | NULL    |       |
	//| paid       | tinyint(1) | NO   |     | NULL    |       |
	//+------------+------------+------+-----+---------+-------+
	
	public Object format_data(int staff_id){
		return new Object[] {
			staff_id,
			"'" + day + "'",
			"'" + start + "'",
			"'" + end + "'",
			0
		};
	}
}