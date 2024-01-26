package com.Rover.EmployData;

import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.StandardOpenOption;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.ByteArrayResource;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.mail.SimpleMailMessage;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;

import jakarta.mail.internet.MimeMessage;

@Service
public class EmployDataServiceInsert {

	@Autowired
	JdbcTemplate jdbcTemplate;
	@Autowired
	JavaMailSender jms;

	public Map<String, Object> register(byte[] fileData, String fileName, String firstName, String lastName, String userName, String email, String officialMail, String password, String dob, String skills, String gender){
        BCryptPasswordEncoder bcrypt=new BCryptPasswordEncoder();

		Map<String, Object> response=new HashMap<String, Object>();
		try {
			int count=0;



			String nameRegex="^[a-zA-Z]+$";
			String emailRegex="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$";
			String passwordRegex="^(?=.*[a-z])(?=.*[A-Z])(?=.*\\W).+$";
			if(firstName=="") {
				response.put("message", "first name can't be empty");
			}else if(!firstName.matches(nameRegex)) {
				response.put("message", "enter only characters in first name");
			}else {
				count++;
			}
			if(lastName=="") {
				response.put("message", "last name can't be empty");
			}else if(!lastName.matches(nameRegex)) {
				response.put("message", "enter only characters in last name");
			}else {
				count++;
			}
			if(email=="") {
				response.put("message", "email can't be empty");
			}else if(!email.matches(emailRegex)) {
				response.put("message", "invalid email format");
			}else {
				count++;
			}
			if(password=="") {
				response.put("message", "password can't be empty");
			}else if(!password.matches(passwordRegex)) {
				response.put("message", "invalid password format");
			}else {
				count++;
			}
			if (dob.equals("")) {
			    response.put("message", "Date of birth can't be empty");
			} else if (!LocalDate.parse(dob, DateTimeFormatter.ofPattern("yyyy-MM-dd")).isBefore(LocalDate.now().minusDays(1))) { 
			    response.put("message", "DOB must be in the past from the current date");
			} else {
			    count++;
			}



			LocalDate date=LocalDate.now();
			String addDate=date.toString();
			String modifyDate=addDate;
			String createdBy=userName;
			if(count==5) {
				String image_name=userName;
				
	            String fileExtension = fileName.substring(fileName.lastIndexOf('.'));
	            
	            fileName = image_name + fileExtension;

	            LocalDate localDate = LocalDate.now(); 
	            int year = localDate.getYear(); 
	            String[] shortMonths = {"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"};
	            String month = shortMonths[LocalDate.now().getMonthValue() - 1];

	            Path imageDirectory =Path.of("C:\\Users\\mcconf\\Downloads\\employ_images\\"+year+"\\"+month);
	            
	            Files.createDirectories(imageDirectory);  

	            String image_path=imageDirectory+"\\"+fileName;
	            
	            Files.write(Path.of(image_path), fileData, StandardOpenOption.CREATE, StandardOpenOption.WRITE);

	   			String encryprtpassword=bcrypt.encode(password);

			String sql="insert into employ_data (firstName,lastName,userName,dob,gender,image,skills,email,password,addDate,modifyDate,createdBy)values(?,?,?,?,?,?,?,?,?,?,?,?)";
			int i=jdbcTemplate.update(sql,firstName,lastName,userName,dob,gender,image_path,skills,officialMail,encryprtpassword,addDate,modifyDate,createdBy);
			if(i>0) {
	            jdbcTemplate.update("INSERT INTO files (userName,file_name) VALUES (?,?)", userName,image_path);
	            jdbcTemplate.update("INSERT INTO testing (firstName, lastName, userName, email, password) VALUES (?,?,?,?,?)", firstName, lastName, userName, officialMail, password);
	            @SuppressWarnings("unused")
				String mail=htmlTemplate( fileData,  fileName,  firstName,  lastName,  userName,  officialMail,  dob,  skills,  gender);
				@SuppressWarnings("unused")
				String mail2=sendMail(email, firstName.toUpperCase(), userName, officialMail);
	            response.put("success", true);
				response.put("data", "");
				response.put("message", "Data Inserted");
			}else {
				response.put("success", false);
			
			}
			}else {
				response.put("success", false);
			}
			
		}catch(Exception e) {
			response.put("error",e.toString());
		}
		System.out.println(response);
		return response;
	}

	public Map<String, String> UserNameCheck(String firstName, String lastName) {

		String userName = usernam(firstName.charAt(0) + lastName);
		Map<String, String> data = new HashMap<String, String>();
		String email = userName + "@miraclesoft.com";
		data.put("email", email);
		data.put("userName",userName);
		return data;
	}


	public String usernam(String userName) {
		String result = userName;
		String seequel="select * from employ_data where userName like'"+userName.toLowerCase()+"%'";
		List<Map<String,Object>> data=new ArrayList<Map<String,Object>>();
		data=jdbcTemplate.queryForList(seequel);
		if(data.size()>=1) {
			result=userName=userName+(data.size());	
		}
		return result.toLowerCase();
	}
	
	public String htmlTemplate(byte[] file, String fileName, String firstName, String lastName, String userName, String email, String dob, String skills, String gender){
		try {
	        MimeMessage message = jms.createMimeMessage();
	        MimeMessageHelper helper = new MimeMessageHelper(message, true);
	        
	        byte[] fileData =file;

            helper.setTo("gudimetlasuvarna@gmail.com");
            helper.setSubject("New Employee Registration: ["+firstName.toUpperCase()+"]");

            	String mail="Dear Admin Team,<br/><br/>\r\n"
            			+ "\r\n\r\n"
            			+ "This email is to inform you that a new employee, ["+firstName.toUpperCase() +"], has registered on our company website.<br><br>"+"\r\n"
            			+ "<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n"
            			+ "<head>\r\n"
            			+ "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n"
            			+ "<title>Miracle</title>\r\n"
            			+ "</head>\r\n"
            			+ "\r\n"
            			+ "<body>\r\n"
            			+ "	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n"
            			+ "		<tr>\r\n"
            			+ "			<td align=\"center\" valign=\"top\" \r\n"
            			+ "				style=\"background-color: #838383;\"><br> <br>\r\n"
            			+ "				<table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n"
            			+ "					<tr>\r\n"
            			+ "						<td align=\"center\" valign=\"top\"\r\n"
            			+ "							style=\"background-image: url('https://hubble.miraclesoft.com/assets/img/bg-login.jpg'); font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #000000; padding: 0px 15px 10px 15px;\">\r\n"
            			+ "							\r\n"
            			+ "                            <form style=\"line-height: 1.8; color:white; background-image: url('https://hubble.miraclesoft.com/assets/img/bg-login.jpg'); padding: 7px;\">\r\n"
            			+ " \r\n"
            			+ "                           <h2>"+firstName+" "+lastName+"    \r\n"
            			+ "\r\n"
            			+ "                                <br><br>\r\n"
            			+ "                                <label>User name : </label>\r\n"
            			+ "                                <b><label id=\"userName\">"+userName+"</label></b>\r\n"
            			+ "                                <label>First name : </label>\r\n"
            			+ "                                <b><label id=\"firstName\">"+firstName+"</label></b><br>\r\n"
            			+ "                                <label class=\"last\">Last name : </label>\r\n"
            			+ "                                <b><label class=\"lastname\" id=\"lastName\">"+lastName+"</label></b>\r\n"
            			+ "                                <label>Dob : </label>\r\n"
            			+ "                                <b><label id=\"dob\">"+dob+"</label></b><br>\r\n"
            			+ "                                    <label>Gender :</label>\r\n"
            			+ "                                    <b><label id=\"gender\">"+gender+"</label></b><br>\r\n"
            			+ "                                    <label>Skills: </label>\r\n"
            			+ "                                    <b><label id=\"skills\">"+skills+"</label></b><br>\r\n"
            			+ "                                <label>Email</label>\r\n"
            			+ "                                <b><label id=\"Email\">"+email+"</label></b>\r\n"
            			+ "                            </form>\r\n"
            			+ "						</td>\r\n"
            			+ "					</tr>\r\n"
            			+ "				</table> <br> <br></td>\r\n"
            			+ "		</tr>\r\n"
            			+ "	</table>\r\n"
            			+ "</body>\r\n"
            			+ "</html>";
            helper.setText(mail, true); 
            helper.addInline(fileName, new ByteArrayResource(fileData), "image/png");
            jms.send(message);
          
			
		
		}catch(Exception e) {
		}
		return "response sended";
	}
	
	public String sendMail(String email, String name, String userName, String officialMail) {
		try {
		SimpleMailMessage sm=new SimpleMailMessage();
	
		
			sm.setFrom("rohithl4681@gmail.com");
			sm.setTo(email);
			
			
			sm.setText("Hi "+name+",\r\n"
					+ "\r\n"
					+ "Thank you for registering with Miracle Software Systems! We're thrilled to have you join our team.\r\n"
					+ "\r\n"
					+ "Your registration is complete, and you can now access all the benefits and resources available to our employees.\r\n"
					+ "\r\n"
					+ "To get started:\r\n"
					+ "\r\n"
					+ "Head over to our employee portal at http://172.17.13.138/ to explore your profile, benefits, and company resources.\r\n"
					+ "Use your registered user name "+userName+"  and the password you chose during registration to log in. We also recommend using your official company email address "+officialMail+" for future communication within the company.\r\n"
					+ "Don't hesitate to reach out to [HR department/Onboarding team contact information] if you have any questions or need assistance navigating the portal.\r\n"
					+ "We encourage you to:\r\n"
					+ "\r\n"
					+ "Explore our website at https://www.miraclesoft.com/ to learn more about our company, mission, and culture.\r\n"
					+ "Connect with your colleagues and build relationships through our https://talk.miraclesoft.com/home.\r\n"
					+ "Get involved in company initiatives and events to discover your full potential.\r\n"
					+ "We're excited to have you on board and look forward to your contributions to Miracle Software Systems!\r\n"
					+ "\r\n"
					+ "Welcome aboard!\r\n"
					+ "\r\n"
					+ "Sincerely,\r\n"
					+ "\r\n"
					+ "The Miracle Software Systems Team\r\n"
					+ "\r\n");

			sm.setSubject(" Welcome to Miracle Software Systems, "+name+"!");
			jms.send(sm);
		
		}catch(Exception e) {
		}
		return "response sending to the user";
	}

}
