import java.sql.*;
import oracle.jdbc.driver.*;

public class TestDataGenerator {

  public static void main(String args[]) {

    try {
      Class.forName("oracle.jdbc.driver.OracleDriver");
      String database = "jdbc:oracle:thin:@oracle-lab.cs.univie.ac.at:1521:lab";
      String user = "a01449508";
      String pass = "gulmira";

      // establish connection to database 
      Connection con = DriverManager.getConnection(database, user, pass);
      Statement stmt = con.createStatement();
	  
	  

		
		for (int i = 1; i <= 2000; i++) {
		 String s= String.valueOf(i);
      try {
	  String insertSql ="INSERT INTO benutzer (kennwort, login)VALUES ('Kennwort"+s+"','login"+s+"')";
	  stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
	}
	}
      ResultSet ra = stmt.executeQuery("SELECT COUNT(*) FROM benutzer");
      if (ra.next()) {
        int count = ra.getInt(1);
        System.out.println("Number of datasets 'Benutzer': " + count);
      }
	 
	 
	  //einfügen in Bewerber
        String[] vorname = {"Lisa", "Lena", "Michael", "Sigrid", "Sussane", "Alex", "Alina", "Marcus", "Frank", "Johan"};
        String[] nachname = {"Parker", "Klimt", "Pitt", "Crus", "Depp", "Brown", "Klark", "Bruk", "Bulloc", "Grey"};
		String[] ort = {"Wien", "Graz", "Linz", "Salzburg", "Innsbruck"};
		
		for (int i = 1; i <= 100; i++) {
		 String s= String.valueOf(i);
      try {
	  String insertSql ="INSERT INTO bewerber (benutzer_id, geburtsdatum, vorname, nachname,ort, telefonnumer, email, adresse) VALUES ( " + i + " ," + "to_date('1988-12-14', 'YYYY-MM-DD')" + " ,'" + vorname[ (int) (Math.random() * 10) ] + "' ,'" + nachname[ (int) (Math.random() * 10) ] + "' ,'" + ort[(int) (Math.random() * 5)] + "' ,'" + "1234"+i + "' ,'muster"+s+"@m.com','Strasse"+s+"')";
	  stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
	}
	}
      // check number of datasets in person table
      ResultSet rb = stmt.executeQuery("SELECT COUNT(*) FROM bewerber");
      if (rb.next()) {
        int count = rb.getInt(1);
        System.out.println("Number of datasets 'Bewerber': " + count);
      }


//einfügen in Arbeitgeber

 String[] bereich = {"IT", "Bank/Versicherung/Immobilien", "Education", "Hotel", "Gesundheit/Soziales", "Erlebnisgastronomie", "Kaufmännischer Dienst", 
 "Catering/Business/Kantine", "Korperpflege", "Wäscherei"};
		
		for (int i = 200; i <= 300; i++) {
		 String s= String.valueOf(i);
      try {
	  String insertSql ="INSERT INTO arbeitgeber(firma_name, adresse, benutzer_id, bereich, ort, telefonnumer, email) VALUES ( 'firmaname"+s+"' ,'Strasse"+s+"' ," + i + " , '" + bereich[ (int) (Math.random() * 10) ] + "' ,'" + ort[(int) (Math.random() * 5)] + "' ,'" + "1234"+i + "' ,'muster"+s+"@m.com')";
	  stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
	}
	}
      ResultSet rd = stmt.executeQuery("SELECT COUNT(*) FROM arbeitgeber");
      if (rd.next()) {
        int count = rd.getInt(1);
        System.out.println("Number of datasets 'ARBEITGEBER': " + count);
      }
	 
     

String[] kategorie = {"Ausbildung/Lehre/Studium", "Bildung/Soziales/Pädagogik", "Einkauf/Lager/Warenlogistik", "Entertainment/Kunst/Kultur", "Event/Veranstaltung",
 "Gebäudedienstleistungen", "Gesundheit/Spa/Sport", "IT/Computer/Internet", "Küche/Speisen/Produktion", "Marketing/PR/Multimedia",  "Reise-/Personenverkehr", 
 "Restaurant/Bar/Service", "Rezeption/Gästebetreuung" , "Sauberkeit/Hygiene", "Vertrieb/Verkauf" , "Verwaltung/Wirtschaft"};
        
		
		for (int i = 0; i <= 15; i++) {
		 String s= String.valueOf(i);
      try {
	  String insertSql ="INSERT INTO kategorie VALUES ( 'beschreibung bla"+s+"' , '" + kategorie[i] + "')";
	  stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
	}
	}
      // check number of datasets in person table
      ResultSet rh = stmt.executeQuery("SELECT COUNT(*) FROM kategorie");
      if (rh.next()) {
        int count = rh.getInt(1);
        System.out.println("Number of datasets 'kategorie': " + count);
      }
	 
//einfügen in Stellenangebote

 int [] gehalt = {800, 900, 1000, 1100, 1200, 1500, 1600, 1700, 2100, 2350, 3000 };
 String [] anstelungsart={"Vollzeit", "Teilzeit" ,"Gerinfuegig", "Praktikum"};
        
		for (int i = 200; i <= 300; i++) {
			String c= String.valueOf(i);
		 for (int j = 1; j <= 10; j++){
		 String s= String.valueOf(j);
      try {
	  String insertSql ="INSERT INTO stellenangebote (beschreibung, title, gehalt, kategname, endzeit, beginzeit, firma_name, anstelungsart) VALUES ( 'beschreibung bla"+s+"' ,'Titel"+s+"',  '" + gehalt[ (int) (Math.random() * 11) ] + "','" + kategorie[ (int) (Math.random() * 16) ] + "', " + "to_date('2018-02-21', 'YYYY-MM-DD')" + ", "+"to_date('2018-01-5', 'YYYY-MM-DD')"+", 'firmaname"+c+"', '" + anstelungsart[ (int) (Math.random() * 4) ] + "')";
	  stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		}
		}}
		 
      // check number of datasets in person table
      ResultSet rs = stmt.executeQuery("SELECT COUNT(*) FROM stellenangebote");
      if (rs.next()) {
        int count = rs.getInt(1);
        System.out.println("Number of datasets 'stellenangebote': " + count);
      }
	  
 
 String [] position={"assistent", "manager" ,"specialist", "Praktikant"};
       
		
		for (int i = 1; i <= 100; i++) {
		
		 String s= String.valueOf(i);
      try {
	  String insertSql ="INSERT INTO lebenslauf (beschreibung, schule, hochschule, kategname, email, position, updatedatum) VALUES ( 'beschreibung bla-bla"+s+"' ,'gymnasium"+s+"', 'Uni"+s+"', '" + kategorie[ (int) (Math.random() * 16) ] + "', 'muster"+s+"@m.com', '" + position[ (int) (Math.random() * 4) ] + "', " + "to_date('2018-01-21', 'YYYY-MM-DD')" + ")";
	  stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		}
		}
		 
      // check number of datasets in person table
      ResultSet rk = stmt.executeQuery("SELECT COUNT(*) FROM lebenslauf");
      if (rk.next()) {
        int count = rk.getInt(1);
        System.out.println("Number of datasets 'lebenslauf': " + count);
      }
	  
	  
	  for (int i = 1; i <= 25; i++) {
		int[] job={202, 210, 256, 288,250,265, 204};
		 String s= String.valueOf(i);
      try {
	  String insertSql ="INSERT INTO stellenangeboteBewerben VALUES ( 'muster"+s+"@m.com', '" + job[ (int) (Math.random() * 7) ] + "')";
	  stmt.executeUpdate(insertSql);
      } catch (Exception e) {
        System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		}
		}
		 
      // check number of datasets in person table
      ResultSet rp = stmt.executeQuery("SELECT COUNT(*) FROM stellenangeboteBewerben");
      if (rp.next()) {
        int count = rp.getInt(1);
        System.out.println("Number of datasets 'stellenangeboteBewerben': " + count);
      }
	  
	  rp.close();
	  rk.close();
	  rh.close();
	  ra.close();
	  rd.close();
	  rb.close();
	  rs.close();
      stmt.close();
      con.close();
     
	
	}
	catch (Exception e) {
      System.err.println(e.getMessage());}
	}
}
