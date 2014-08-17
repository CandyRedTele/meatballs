import java.util.ArrayList;

public class ShiftSet{
	/**
	 * [day][facility][time][concurrent]
	 */
	
	//final int type;
	//final int numConc = 3;
	final int numDays = 7;
	final int numTimes = 2;
	final int numFacil = 12;

	Shift[][][]/*[]*/ shifts = new Shift[7][2][12];//[numConc];
	
	
	
	public ShiftSet(int type){
	  //this.type = type;
	  for(int day = 0; day < numDays; day++){
	    for(int time = 0; time < numTimes; time++){
		  for(int facil = 0; facil < numFacil; facil++){
			//for(int conc = 0; conc < numConc; conc++){
			  shifts[day][time][facil] = //[conc] = 
					  new Shift(time, type, day);
			//}
		  }
	    }
	  }
	}
	
	public String toString(){
		
		String str = "";
		for(int day = 0; day < 7; day++){
		    for(int time = 0; time < 2; time++){
		      for(int fac = 0; fac < 12; fac++){
					str += shifts[day][time][fac].toString() + "\n";
		      }
		    }
		}
		return str;
	}
	
	public Shift[] getStaffShifts(int type, int numShifts, int facility, int staff_id){
		
		Shift[] staffShifts = new Shift[numShifts];
		
		System.out.println(numShifts);
		
		for(int shift = 0; shift < numShifts; shift++){
			boolean gotShift = false;
			if(generate_data.debug)
				System.out.println("shift" + shift);
			for(int day = 0; day < numDays; day++){
				if(generate_data.debug)System.out.println("day" + day);
				for(int time = 0; time < numTimes; time++){
					if(generate_data.debug)System.out.println("time" + time);
					if(shift_available(day,time,facility, staff_id)
							&&gotShift == false){
						Shift tmp = removeShift(day, time, facility, staff_id);
						if(generate_data.debug)System.out.println(tmp);
						if(tmp != null){
							gotShift = true;
							staffShifts[shift] = tmp;
						}
					}
				}
			}
		}
		
		return staffShifts;
		
	}
	
	private Shift checkShift(int day,int time, int facility, int staff_id/*, int concurrent*/){
		
		if(generate_data.debug)System.out.println(" day " + day + " time " + time + " facility " + facility + " staff_id " + staff_id);
		return shifts[day][time][facility];//[concurrent];
	
	}
	
	private Shift removeShift(int day, int time, int facility, int staff_id){
		
		//for(int concurrent = 0; concurrent < numConc; concurrent++){
		Shift tmpShift = checkShift(day,time,facility,staff_id);
		if(tmpShift.canTake(staff_id)){
			Shift retShift = shifts[day][time][facility].take(staff_id);
			return retShift;
		}
		//}
		return null;
		
	}
	
	
	private boolean shift_available(int day,int time, int facility, int staff_id){
		
		//for(int concurrent = 0; concurrent < numConc; concurrent++){
		Shift tmpShift = checkShift(day,time,facility,staff_id);

		if(tmpShift.canTake(staff_id)){
			return true;
		}
		//}
		return false;
		
	}
}
