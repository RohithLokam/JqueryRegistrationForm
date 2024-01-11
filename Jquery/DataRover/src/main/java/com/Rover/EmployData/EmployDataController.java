package com.Rover.EmployData;

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



@RestController
@CrossOrigin(origins="*")
public class EmployDataController {

	@Autowired
	EmployDataService employDataService;
	@Autowired
	EmployDataServiceInsert employDataServiceInsert; 
	@Autowired
	EmploySearch employSearch;
	
	@Autowired
	SendMail sm;

	@PostMapping("employ_data")
	public Map<String, Object> datainsertion(@RequestBody EmployData employData){
		return employDataServiceInsert.insertEmployData(employData);
	}
	@PutMapping("employ_data")
	public Map<String, Object> updation(@RequestBody EmployData employDataUpdate){	
		return employDataService.update(employDataUpdate);
	}
	@GetMapping("employ_data/{key}")
	public Map<String, Object> listing(@PathVariable String key){
		return employDataService.list(key);
	}
	@GetMapping("employ_data_list")
	public Map<String, Object> selection(@RequestParam int employId){	
		return employDataService.view(employId);
	}
	
	
	@GetMapping("user_name_check/{firstName}/{lastName}")
	public Map<String, String> userNameChecking(@PathVariable String firstName,@PathVariable String lastName){
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
	
}
