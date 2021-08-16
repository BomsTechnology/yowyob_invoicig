package boms.management.billng.api.controller;

import java.util.ArrayList;
import java.util.List;
import java.util.Optional;
import java.util.UUID;

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

import boms.management.billng.api.model.Product;
import boms.management.billng.api.repository.ProductRepository;

@CrossOrigin(origins = "http://localhost:8080")
@RestController
@RequestMapping("/api")
public class ProductController {
	
	@Autowired
	ProductRepository productRepository;
	
	  @PostMapping("/products")
	  public ResponseEntity<Product> createProduct(@RequestBody Product product) {
	    try {
	    	Product _product = productRepository.save(new Product(Uuids.timeBased(), product.getName(), product.getPrice()));
	      return new ResponseEntity<>(_product, HttpStatus.CREATED);
	    } catch (Exception e) {
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	  
	  @GetMapping("/products")
	  public ResponseEntity<List<Product>> getProducts() {
	    try {
	      List<Product> products = new ArrayList<Product>();

	    	  productRepository.findAll().forEach(products::add);


	      if (products.isEmpty()) {
	        return new ResponseEntity<>(HttpStatus.NO_CONTENT);
	      }

	      return new ResponseEntity<>(products, HttpStatus.OK);
	    } catch (Exception e) {
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }
	  
	  @GetMapping("/productById/{id}")
	  public ResponseEntity<Product> getProductById(@PathVariable("id") UUID id) {
	    Optional<Product> productData = productRepository.findById(id);

	    if (productData.isPresent()) {
	      return new ResponseEntity<>(productData.get(), HttpStatus.OK);
	    } else {
	      return new ResponseEntity<>(HttpStatus.NOT_FOUND);
	    }
	  }
          
          @GetMapping("/productByName/{value}")
	  public ResponseEntity<List<Product>> search(@PathVariable("value") String value) {
              try {
                  List<Product> products = new ArrayList<Product>();
              productRepository.search(value).forEach(products::add);

	    if (products.isEmpty()) {
	        return new ResponseEntity<>(HttpStatus.NO_CONTENT);
	      }

	      return new ResponseEntity<>(products, HttpStatus.OK);
              } catch (Exception e) {
	      return new ResponseEntity<>(null, HttpStatus.INTERNAL_SERVER_ERROR);
	    }
	  }

}
