package com.Rover.EmployData;

import java.io.IOException;
import java.util.HashMap;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.multipart.MultipartFile;




@RestController
@CrossOrigin(origins="*")
public class EmployDataController {

	@Autowired
	EmployDataService employDataService;
	@Autowired
	EmployDataServiceInsert employDataServiceInsert; 
	@Autowired
	EmploySearch employSearch;
//	@Autowired
//    private GenerateKey jwtUtils;
	@Autowired
	SendMail sm;

	@PostMapping("employ_data")
	public Map<String, Object> registration(@RequestParam("file") MultipartFile file, @RequestParam("firstName") String firstName, @RequestParam("lastName") String lastName,  @RequestParam("userName") String userName, @RequestParam("email") String email, @RequestParam("officialMail") String officialMail, @RequestParam("password") String password, @RequestParam("dob") String dob, @RequestParam("skills") String skills, @RequestParam("gender") String gender) throws IOException{
		return employDataServiceInsert.register(file.getBytes(), file.getOriginalFilename(), firstName, lastName, userName, email, officialMail, password, dob, skills, gender);
	}
	
	@PutMapping("employ_data")
	public Map<String, Object> updation(@RequestParam("file") MultipartFile file,  @RequestParam("employId") int employId, @RequestParam("userName") String userName, @RequestParam("firstName") String firstName, @RequestParam("lastName") String lastName, @RequestParam("email") String email, @RequestParam("dob") String dob, @RequestParam("skills") String skills, @RequestParam("gender") String gender) throws IOException{
		return employDataService.update(file.getBytes(), file.getOriginalFilename(), employId, userName, firstName, lastName, email, dob, skills, gender);
	}
	@GetMapping("employ_data/{key}")
	public Map<String, Object> listing(@PathVariable String key) throws IOException {
	        return employDataService.list(key);
	    
	}
	
	@GetMapping("employ_data_list")
	public Map<String, Object> selection(@RequestParam int employId){	
		return employDataService.view(employId);
	}
	@GetMapping("user_name_check")
	public Map<String, String> userNameChecking(@RequestParam String firstName,@RequestParam String lastName){
		return employDataServiceInsert.UserNameCheck(firstName,lastName);
	}
	@GetMapping("select")
	public Map<String, Object> employSelection(@RequestParam String name){
		return employSearch.selection(name);
	}
	@PostMapping("employ")
	public Map<String,Object> employLogin(@RequestBody EmployData employData){
		return employDataService.login(employData);
	}
	@PostMapping("sendmail")
	public Map<String,Object> sending_mail(@RequestBody EmployData employData) {
		return sm.sendMail(employData);
	}
	@PostMapping("otp_verification")
	public Map<String,Object> otp_verification(@RequestBody EmployData employData) {
		return sm.otpVerification(employData);
	}
	@PostMapping("password_update")
	public Map<String,Object> password_update(@RequestBody EmployData employData) {
		return sm.passwordUpdate(employData);
	}
	@PostMapping("reset_password")
	public Map<String,Object> reset_password(@RequestBody EmployData employData) {
		return employDataService.resetPassword(employData);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
//	@PostMapping("files")
//    public Map<String, Object> handleFileUpload(@RequestPart("file") MultipartFile file) throws IOException {
//        return employDataService.saveFile(file.getBytes(), file.getOriginalFilename());
//    }
	@PostMapping("files")
	public Map<String, Object> handleFileUpload(@RequestParam("file") MultipartFile file, @RequestBody EmployData employData) {
	    try {
	        return employDataService.saveFile(file.getBytes(), file.getOriginalFilename(), employData);
	    } catch (IOException e) {
	        return handleFileUploadError(e);
	    }
	}

	private Map<String, Object> handleFileUploadError(Exception e) {
	    e.printStackTrace(); 
	    Map<String, Object> response = new HashMap<>();
	    response.put("message", "Error uploading the file");
	    response.put("success", false);
	    return response;
	}
	
	@PostMapping("html")
	public Map<String, Object> email_template(@RequestParam("file") MultipartFile file, @RequestParam("firstName") String firstName, @RequestParam("lastName") String lastName,  @RequestParam("userName") String userName, @RequestParam("email") String email, @RequestParam("dob") String dob, @RequestParam("skills") String skills, @RequestParam("gender") String gender) throws IOException{
		return sm.htmlTemplate(file.getBytes(), file.getOriginalFilename(), firstName, lastName, userName, email, dob, skills, gender);
	
	}
	
}
