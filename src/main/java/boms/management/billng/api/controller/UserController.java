package boms.management.billng.api.controller;

import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.datastax.oss.driver.api.core.uuid.Uuids;
import boms.management.billng.api.model.User;
import boms.management.billng.api.repository.UserRepository;

@CrossOrigin(origins = "http://localhost:8080")
@RestController
@RequestMapping("/api")
public class UserController {
	
	@Autowired
	UserRepository userRepository;
	
	@PostMapping("/user")
	public ResponseEntity<User> createUser(@RequestBody User user) {
	    try {
	    	User _user = userRepository.insert(new User(Uuids.timeBased(), user.getLogin(), user.getPassword()));
	      return new ResponseEntity<>(_user, HttpStatus.CREATED);
	    } catch (Exception e) {
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	
	@GetMapping("/user/{login}/{password}")
	public ResponseEntity<User> authentificate(@PathVariable("login") String login, @PathVariable("password") String password) {
			  Optional<User> user = userRepository.authentificate(login, password);

		      if (user.isPresent()) {
		      return new ResponseEntity<>(user.get(), HttpStatus.OK);
		    } else {
		      return new ResponseEntity<>(HttpStatus.NOT_FOUND);
		    }

		}
}