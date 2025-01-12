# GenealogyTree
https://dbdiagram.io/d/67832cde6b7fa355c399cc4c le lien de ma conception de la base de données 

2) dans le système crée les utilisateur peuvent proposer des modifications ou suggéerer des nouvelles connexions entre les familles du coup les données evoluent soit
   - en créant une proposition en proposant une modification --> novelle ligne dans la table proposition avec l'id ou de la relation , et toujours une initialisation faite sur les approba et le rejet
   - en enregistrement des réponses aux propositions puisque les membre de la communauté ils peuvent rejeter ou approuver la propo une nouvelle ligne créer dans la table proposition_Response

     POUR la validation des modifs :
     chaque action relative a lappro ou le rejet implique la MAJ sur pepole et Relationsships
     
     - Approbation : chaque approba incrémeent notre compte dans la table de propositions si le compte atteind 3 appro du coup notre attribut is_approved devient true et les modifs seront appliqué par la suite aux people et Relationships
     - Rejet : chaque rejet incrémente le compte et mm prinicipe 3 rejet implqiue la proposotion est supprimé
    
       tout ce système mis permet de bien garantir la verification de la communauté avant tout modif du coup notre système est bien mis en oeuvre et répond aux exigence demandée.
    

       Merci pour la chance accordée.
       
     

  
