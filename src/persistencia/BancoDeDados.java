package persistencia;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class BancoDeDados {
	private static Connection bd = null;
	
	public static Connection getBd() {
		
		if (bd == null) {
			try {
				bd = DriverManager.getConnection(
						"jdbc:mysql://localhost:3306/bd_coleo",
						"root",
						"root"
						);
			} catch (SQLException e) {
				// erro ao conectar ao bd, vamos imprimir o stack trace e encerrar
				e.printStackTrace();
				System.exit(1);
			}
		}
		return bd;
	}
}