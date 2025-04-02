package fr.univamu.iut.glassfishtest1;

import java.util.*;

public interface ProduitRepositoryInterface {

    List<Produit> getProduits();

    Produit getProduitById(int id);

    void updateProduit(Produit produit);

    void createProduit(Produit produit);

    void deleteProduit(int id);
}
