package com.Rover.EmployData;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardOpenOption;
import java.time.LocalDate;
import java.util.ArrayList;
import java.util.Base64;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;


@Service
public class EmployDataService {
	static String username;

	@Autowired
	JdbcTemplate jdbcTemplate;
	
	 public Map<String, Object> login(EmployData employData) {
	        String passKey = "Rohit";
	        BCryptPasswordEncoder bcrypt = new BCryptPasswordEncoder();
	        Map<String, Object> response = new HashMap<>();

	        try {
	            String userName = employData.getUserName();
	            String password = employData.getPassword();
	            System.out.println(userName);
	            System.out.println(password);

	            String sql = "select employId, firstName, lastName, image, password from employ_data where userName=?";

	            List<Map<String, Object>> result = jdbcTemplate.queryForList(sql, userName);

	            if (!result.isEmpty()) {
	                Map<String, Object> userData = result.get(0);
	                String encryptPassword = (String) userData.get("password");

	                if (bcrypt.matches(password, encryptPassword)) {
	                    System.out.println("condition2");

	                    String imagePath = (String) userData.get("image");
	                    Path path = Paths.get(imagePath);
	                    byte[] imageBytes = Files.readAllBytes(path);
	                    String base64Image = Base64.getEncoder().encodeToString(imageBytes);

	                    System.out.println("imagePath: " + imagePath);
	                    for (Map<String, Object> map : result) {
	                        map.put("passKey", passKey);
	                        map.put("image", base64Image);
	                    }

	                    response.put("success", true);
	                    response.put("message", "credentials are valid");
	                    response.put("data", result);
	                } else {
	                    System.out.println("condition1");
	                    System.out.println(password);
	                    response.put("success", false);
	                    response.put("message", "invalid credentials");
	                    response.put("data", null);
	                }
	            } else {
	                response.put("success", false);
	                response.put("message", "user not found");
	                response.put("data", null);
	            }
	        } catch (Exception e) {
	            response.put("message", "error: " + e);
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
		 Map<String, Object> userData = resultData.get(0);
         String imagePath = (String) userData.get("image");
         Path path = Paths.get(imagePath);
         byte[] imageBytes = Files.readAllBytes(path);
         String base64Image = Base64.getEncoder().encodeToString(imageBytes);

         System.out.println("imagePath : "+imagePath);
         for(Map<String,Object> map: resultData) {
			map.put("image", base64Image);
		}
		result.put("data", resultData); 
		System.out.println(resultData);
	}
		catch(Exception e) {
			result.put("message", "error: "+e.getMessage());
			
		}
		return result;

	}




	public Map<String, Object> update(byte[] fileData, String fileName,int employId, String userName, String firstName,String lastName, String email, String dob, String skills, String gender){
		Map<String, Object> response=new HashMap<String, Object>();
		try {	
			LocalDate date=LocalDate.now();
			String addDate=date.toString();
			String modifyDate=addDate;
			String createdBy=firstName.substring(0,1)+lastName;
			String image_name=userName;
			
            String fileExtension = fileName.substring(fileName.lastIndexOf('.'));
            System.out.println(userName);

            fileName = image_name + fileExtension;
            System.out.println(fileName);

            LocalDate localDate = LocalDate.now(); 
            int year = localDate.getYear(); 
            String[] shortMonths = {"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"};
            String month = shortMonths[LocalDate.now().getMonthValue() - 1];

            Path imageDirectory =Path.of("C:\\Users\\mcconf\\Downloads\\employ_images\\"+year+"\\"+month);
            
            Files.createDirectories(imageDirectory);  

            String image_path=imageDirectory+"\\"+fileName;
            System.out.println(image_path);
            
            Files.write(Path.of(image_path), fileData, StandardOpenOption.CREATE, StandardOpenOption.WRITE);

	
            System.out.println(image_path);

			String sql="update employ_data set firstName=?,lastName=?,dob=?,gender=?,skills=?,image=?,email=?,modifyDate=?,createdBy=? where employId=?";
			int i=jdbcTemplate.update(sql,firstName,lastName,dob,gender,skills,image_path,email,modifyDate,createdBy,employId);
			if(i>0) {
	            jdbcTemplate.update("update  files set file_name=? where employId=?", image_path,employId);

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

	public Map<String, Object> list(String key) throws IOException {
		String passkey="Rohit";
		Map<String, Object> dataObject = new HashMap<>();    
		if(passkey==key || passkey.equals(key)) {
		String sql = "select employId, firstName, lastName, userName, dob, gender, skills, email, image from employ_data";
		List<Map<String, Object>> resultData = jdbcTemplate.queryForList(sql);
		Map<String, Map<String, Object>> resultMap = new HashMap<>();
		for (Map<String, Object> row : resultData) {
			String employId = String.valueOf(row.get("employId"));
	         String imagePath = (String) row.get("image");
	         Path path = Paths.get(imagePath);
	         byte[] imageBytes = Files.readAllBytes(path);
	         String base64Image = Base64.getEncoder().encodeToString(imageBytes);
	         row.put("image", base64Image);
			resultMap.put(employId, row);
		}
		dataObject.put("success", true);
		dataObject.put("message", "retrived all employes data list.");
		dataObject.put("data", resultMap);
		
		}
		return dataObject;
	}



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
        BCryptPasswordEncoder bcrypt=new BCryptPasswordEncoder();
		Map<String, Object> response=new HashMap<String, Object>();
		try {
			String password=edp.getPassword();
			int employId=edp.getEmployId();

			String sql="update employ_data set password=? where employId=?";
   			String encryprtpassword=bcrypt.encode(password);
			int i=jdbcTemplate.update(sql,encryprtpassword,employId);
			if(i>0) {
				jdbcTemplate.update("update testing set password=? where employId=?",password,employId);
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
	
	
	 public Map<String, Object> saveFile(byte[] fileData, String fileName, EmployData employData) {
	        Map<String, Object> response = new HashMap<>();

	        try {
	        	String ownerName=employData.getUserName();
	            String fileExtension = fileName.substring(fileName.lastIndexOf('.'));
	            
	            fileName = ownerName + fileExtension;

	            String filePath = "C:\\Users\\mcconf\\Downloads\\employ_images\\" + fileName;

	            Files.write(Path.of(filePath), fileData, StandardOpenOption.CREATE, StandardOpenOption.WRITE);
	            


	            jdbcTemplate.update("INSERT INTO files (file_name) VALUES (?)", filePath);

	            response.put("message", "File uploaded successfully");
	            response.put("success", true);
	        } catch (IOException e) {
	            e.printStackTrace();
	            response.put("message", "Error uploading the file");
	            response.put("success", false);
	        }

	        return response;
	    }
	
	
	
}
