package com.Rover.EmployData;

import java.time.LocalDate;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;


@Service
public class EmployDataService {
	static String username;

	@Autowired
	JdbcTemplate jdbcTemplate;
	
	
	
	public Map<String,Object> login(EmployData employData){
		String passKey="Rohit";
		Map<String,Object> response=new HashMap<String,Object>();
		try {
			String userName=employData.getUserName();
			String password=employData.getPassword();
			System.out.println(userName);
			System.out.println(password);

			String sql="select userName,password from employ_data where userName=? and password=?";
			
			String seequel="select employId,firstName,lastName,image,password from employ_data where userName=? and password=?";
			
			List<Map<String,Object>> result=new ArrayList<Map<String,Object>>();
			
			result=jdbcTemplate.queryForList(sql,userName,password);
			System.out.println(result);
			if(result.isEmpty()) {
				response.put("success", false);
				response.put("message", "invalid credentials");
				response.put("data", null);
			}else {
				List<Map<String,Object>> result1=new ArrayList<Map<String,Object>>();
				result1=jdbcTemplate.queryForList(seequel,userName,password);
				for(Map<String,Object> map: result1) {
					map.put("passKey", passKey);
				}
				response.put("success", true);
				response.put("message", "credentials are valid");
				response.put("data", result1);
			}
		}catch(Exception e) {
			response.put("message", "error :"+e);
		}
		return response;
	}



	public Map<String, String> insertEmployData(EmployData employData){
		Map<String, String> response=new HashMap<String, String>();
		try {

			String firstName=employData.getFirstName();
			String lastName=employData.getLastName();
			String userName=username;



			String dob=employData.getDob();
			String gender=employData.getGender();
			String skills=employData.getSkills();
			String email=employData.getEmail();
			String password=employData.getPassword();
			LocalDate date=LocalDate.now();
			String addDate=date.toString();
			String modifyDate=addDate;
			String createdBy=firstName.substring(0,1)+lastName;
			String sql="insert into employ_data (firstName,lastName,userName,dob,gender,skills,email,password,addDate,modifyDate,createdBy)values(?,?,?,?,?,?,?,?,?,?,?)";
			int i=jdbcTemplate.update(sql,firstName,lastName,userName,dob,gender,skills,email,password,addDate,modifyDate,createdBy);
			if(i>0) {
				response.put("success", "data inserted");
			}else {
				response.put("failure", "data not inserted");
			}
		}catch(Exception e) {
			response.put("error",e.toString());
		}
		return response;
	}

	public Map<String, Object> view(int id) {
		Map<String, Object> result=new HashMap<String, Object>();
		try {
		String sql = "select * from employ_data where employId=?";
		List<Map<String, Object>> resultData = jdbcTemplate.queryForList(sql, id);
		if(result.size()>0) {
			result.put("success", true);
		}else {
			result.put("success", false);
		}
		result.put("data", resultData); 
	}
		catch(Exception e) {
			result.put("message", "error: "+e.getMessage());
			
		}
		return result;

	}



	//	public List<Map<String, Object>> list(int id){
	//		String sql="select *  from employ_data where employId=?";
	//		List<Map<String,Object>> ResultData=jdbcTemplate.queryForList(sql,id);
	//		return ResultData ;
	//	}


	public Map<String, Object> update(EmployData edp){
		Map<String, Object> response=new HashMap<String, Object>();
		try {
			int employId=edp.getEmployId();
			String firstName=edp.getFirstName();
			String lastName=edp.getLastName();


			String dob=edp.getDob();
			String gender=edp.getGender();
			String skills=edp.getSkills();
			String email=edp.getEmail();
			LocalDate date=LocalDate.now();
			String addDate=date.toString();
			String modifyDate=addDate;
			String createdBy=firstName.substring(0,1)+lastName;
			byte[] image=edp.getImage();
			System.out.println(image);


			String sql="update employ_data set firstName=?,lastName=?,dob=?,gender=?,skills=?,image=?,email=?,modifyDate=?,createdBy=? where employId=?";
			int i=jdbcTemplate.update(sql,firstName,lastName,dob,gender,skills,image,email,modifyDate,createdBy,employId);
			if(i>0) {
				String seequel="select firstName,lastname,image from employ_data where employId=?";
				List<Map<String,Object>> result=jdbcTemplate.queryForList(seequel,employId);
				response.put("data", result);
				response.put("success", true);
				response.put("message", "data updated successfully");
			}else {
				response.put("data", null);
				response.put("success", false);
				response.put("message", "data not updated");

			}		
		}catch(Exception e) {
			response.put("data", null);
			response.put("success", false);
			response.put("message", e.toString());
		}
		return response;
	}

	public Map<String, Object> list(String key) {
		String passkey="Rohit";
		Map<String, Object> dataObject = new HashMap<>();    
		if(passkey==key || passkey.equals(key)) {
		String sql = "select employId, firstName, lastName, userName, dob, gender, skills, email from employ_data";
		List<Map<String, Object>> resultData = jdbcTemplate.queryForList(sql);
		Map<String, Map<String, Object>> resultMap = new HashMap<>();
		for (Map<String, Object> row : resultData) {
			String employId = String.valueOf(row.get("employId"));
			resultMap.put(employId, row);
		}
		dataObject.put("success", true);
		dataObject.put("message", "retrived all employes data list.");
		dataObject.put("data", resultMap);
		
		}
		return dataObject;
	}



	//	public Map<String, Map<String, Object>> view() {
	//	    String sql = "select employId, firstName, lastName, userName, dob, gender, skills, email from employ_data";
	//	    List<Map<String, Object>> resultData = jdbcTemplate.queryForList(sql);
	//	    Map<String, Map<String, Object>> resultMap = new HashMap<>();
	//	    for (Map<String, Object> row : resultData) {
	//	        String employId = String.valueOf(row.get("employId"));
	//	        resultMap.put(employId, row);
	//	    }
	//	    return resultMap;
	//	}


	//	public List<Map<String, Object>> view(){
	//		String sql="select employId,firstName, lastName,userName,dob,gender, skills,email  from employ_data";
	//		List<Map<String,Object>> ResultData=jdbcTemplate.queryForList(sql);
	//		return ResultData ;
	//	}

	public Map<String,String> UserNameCheck(String firstName,String lastName){
		String userName=usernam(firstName.charAt(0)+lastName);
		username=userName;
		Map<String,String> data=new HashMap<String,String>();
		String email=userName+"@miraclesoft.com";
		data.put("email",email);
		return data;
	}

	public String usernam(String userName) {
		String result = userName;
		String seequel="select * from employ_data where userName like'"+userName+"%'";
		List<Map<String,Object>> data=new ArrayList<Map<String,Object>>();
		data=jdbcTemplate.queryForList(seequel);
		if(data.size()>=1) {
			result=userName=userName+(data.size());	
		}
		return result;
	}
	
	public Map<String, Object> resetPassword(EmployData edp){
		Map<String, Object> response=new HashMap<String, Object>();
		try {
			String password=edp.getPassword();
			int employId=edp.getEmployId();

			String sql="update employ_data set password=? where employId=?";
			int i=jdbcTemplate.update(sql,password,employId);
			if(i>0) {
				response.put("success", true);
				response.put("message", "Password updated successfully");
			}else {
				response.put("success", false);
				response.put("message", "Password not updated");

			}		
		}catch(Exception e) {
			response.put("success", false);
			response.put("message", e.toString());
		}
		return response;
	}
	
	
	
	
}
