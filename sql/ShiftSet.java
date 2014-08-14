public class ShiftSet{
	/**
	 * [day][facility][time][concurrent]
	 */
	
	final int numConc = 3;
	shift[][][][] shifts = new shift[7][12][2][numConc];
	
	
	public ShiftSet(int type){
	  for(int day = 0; day < 7; day++){
	    for(int fac = 0; fac < 12; fac++){
	      for(int time = 0; time < 2; time++){
			for(int conc = 0; conc < numConc; conc++){
			  shifts[day][fac][time][conc] = 
					  new shift(time, type, day);
			}
		  }
	    }
	  }
	}
	
	public String toString(){
		
		String str = "";
		for(int day = 0; day < 7; day++){
		    for(int fac = 0; fac < 12; fac++){
		      for(int time = 0; time < 2; time++){
				for(int conc = 0; conc < 3; conc++){
					str += shifts[day][fac][time][conc].toString() + "\n";
				}
		      }
		    }
		}
		return str;
	}
	
	class shift{
		public int start;
		public int end;
		public int day;
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
		
		public shift(int start, int type, int day){

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
		
		public String toString(){
			return("start, " + start + " end, " + end + " day, " + days[day]);
		}
	}
}
