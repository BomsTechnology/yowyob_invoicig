package boms.management.billng.api.controller;

import java.util.ArrayList;
import java.util.List;
import java.util.UUID;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import boms.management.billng.api.model.ProductByBill;
import boms.management.billng.api.model.ProductByBillKey;
import boms.management.billng.api.repository.ProductByBillRepository;

@CrossOrigin(origins = "http://localhost:8080")
@RestController
@RequestMapping("/api")
public class ProductByBillController {

	@Autowired
	ProductByBillRepository productByBillRepository;
	
	@GetMapping("/productByBills")
	  public ResponseEntity<List<ProductByBill>> getAllProductByBills() {
	    try {
	      List<ProductByBill> productByBills = new ArrayList<ProductByBill>();

	      productByBillRepository.findAll().forEach(productByBills::add);

	      return new ResponseEntity<>(productByBills, HttpStatus.OK);
	    } catch (Exception e) {
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }

	  @PostMapping("/productByBills")
	  public ResponseEntity<ProductByBill> createProductByBill(@RequestBody ProductByBill productByBill) {
	    try {

	    	ProductByBill _billByCustomer = productByBillRepository.insert(new ProductByBill(productByBill.getKey(), productByBill.getName(), productByBill.getPrice(), productByBill.getQuantity(), productByBill.getAmount()));
	      return new ResponseEntity<>(_billByCustomer, HttpStatus.CREATED);
	    } catch (Exception e) {
	    	e.printStackTrace();
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	  
	  @DeleteMapping("/productByBills")
	  public ResponseEntity<HttpStatus> deleteBill(@RequestBody ProductByBillKey key) {
	    try {
	    	productByBillRepository.deleteById(key);
	      return new ResponseEntity<>(HttpStatus.NO_CONTENT);
	    } catch (Exception e) {
	      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	  
	  @GetMapping("/productByBills/bills/{id}")
	  public ResponseEntity<List<ProductByBill>> findByBillId(@PathVariable("id") UUID id) {
	    try {
	      List<ProductByBill> productByBills = productByBillRepository.findByBillId(id);

	      if (productByBills.isEmpty()) {
	        return new ResponseEntity<>(HttpStatus.NO_CONTENT);
	      }
	      return new ResponseEntity<>(productByBills, HttpStatus.OK);
	    } catch (Exception e) {
	      return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
}
