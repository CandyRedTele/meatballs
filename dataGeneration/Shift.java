public class Shift{
	
	static final int cook = 0;
	static final int dish = 1;
	static final int wait = 2;
	static final int supervisor = 3;
	int[] taken = new int[3];
	public int start;
	public int end;
	public int day;
	public String title;
	
	/**
	 * 
	 * @param start an int between 0 and 1 that says whether it's a morning or night shift
	 * @param type the type of the employee
	 * @param day they day of the week on which it occurs. monday == 0; sunday == 6
	 */
	public Shift(int time, int type, int day){
		
		int regMorning = 0;
		int regNoon = 0;
		int regNight = 0;
		int fridayMorning = 0;
		int fridayNoon = 0;
		int fridayNight = 0;
		
		if(type == cook || type == dish){
			
			//cook or dish:
			//	11 + 8 = 19 + 8 = 27:00
			//	close is usually at 23:00
			//	regular day, cook dish start 11 - 3 = 8:00 and end at 11+1 = 12
			//	so shifts would be 8-16, and 16-12
			//
			//	Fridays and Saturdays, close is at 25:00(1:00 the next day.)
			//	on Fridays and Saturdays, cook and dish should start at 25-16 = 9
			//	that means their shifts would be 9-17, and 17-25 (1:00)
			
			if(type == cook)
				title = "cook";
			if(type == dish)
				title ="dishwasher";
			
			regMorning = 8;
			regNoon = 16;
			regNight = 12;
			fridayMorning = 9;
			fridayNoon = 17;
			fridayNight = 25;
			
		}
		if(type == wait||type == supervisor){
			
			/*wait/shift supervisors employees start at 11 every day
			 *	on regular days, there are two 6 hour shifts.
			 *		shifts are 11-17,17-23
			 *	on irregular days, there is one 6 hour shift and one 8 hour shift. 
			 *		the shifts are 11-17, 17-25
			 * 
			 */
			if(type == wait){
				title = generate_data.titles[generate_data.WaitId];
			}
			if(type == supervisor){
				title = generate_data.titles[generate_data.supervId];
			}
			
			regMorning = 11;
			regNoon = 17;
			regNight = 23;
			fridayMorning = 11;
			fridayNoon = 17;
			fridayNight = 25;
			
			
		}
		
		//if morning shift
		if (time == 0){
			//if Friday or Saturday
			if(day == 4 || day == 5){
				this.start = fridayMorning;
				this.end = fridayNoon;
			}
			//any other day
			else{
				this.start = regMorning;
				this.end = regNoon;
			}	
		}
		//if night shift
		if(time == 1){
			if(day == 4 || day == 5){
				this.start = fridayNoon;
				this.end = fridayNight%24;
			}
			else{
				this.start = regNoon;
				this.end = regNight%24;
			}
		}
		this.day = day;
		/*
		int weekendExtra = 0;
		
		if((day == 4 || day == 5)&&(start == 1)){
			weekendExtra = 2;
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
		this.end = (start + shifthours[type] + weekendExtra)%24;
		this.day = day;*/
	}
	
	public Shift take(int staff_id){
		for(int i = 0; i < taken.length; i++){
			if(taken[i] == staff_id){
				System.out.println("Shift take rejected. Staff #" + staff_id 
						+ "is already doing Shift");
				System.exit(0);
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
		if(taken[0] == 0 || taken[1] == 0 || taken[2] == 0){
			return("start, " + start + " end, " + end + " day, " + generate_data.days[day]);

		}
		else{
			return "shift taken";	
		}
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
	
	public Object format_data(int seeday, int month, 
			int year, int staff_id){
		
		String startString = formathour(start);
		String endString = formathour(end);
		return new Object[] {
			staff_id,
			"'" + formatDate(seeday,day,month,year) + "'",
			"'" + startString + "'",
			"'" + endString + "'",
			0
		};
	}
	
	private String formatDate(int seeday, int day, int month, int year){
		String daystr;
		String monthstr;
		String yearstr;
		if(day+seeday < 10){
			System.out.println("day violator: " + day + "" + seeday);
			daystr = "0" + (day+seeday);
		}
		else daystr = "" + (day+seeday);
		
		if(month < 10)monthstr = "0" + month;
		else monthstr = "" + month;
		
		yearstr = "" + year;
		
		return yearstr + "-" + monthstr + "-" + daystr;
		
	}
	
	private String formathour(int hour){
		
		if(hour < 10){
			return "0" + hour + ":00:00";
		}
		else{
			return hour + ":00:00";
		}
		
	}
}