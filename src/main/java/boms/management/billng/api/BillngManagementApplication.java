package boms.management.billng.api;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.ComponentScan;

@SpringBootApplication
@ComponentScan({"package boms.management.billng.api.controller;"})
public class BillngManagementApplication {

	public static void main(String[] args) {
		SpringApplication.run(BillngManagementApplication.class, args);
	}

}
