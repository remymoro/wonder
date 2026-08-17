# Wonder — contenu portfolio

Textes prêts à copier-coller, du format le plus court au plus détaillé.
Projet réalisé dans le cadre du parcours **Symfony** de la plateforme de formation **Dyma**.

---

## 1. Carte projet (version courte, ~40 mots)

> **Wonder — Plateforme de questions/réponses**
> Application web full-stack type « Stack Overflow » : publication de questions, réponses,
> système de votes, recherche instantanée et back-office d'administration.
> Réalisée avec Symfony 6.2, Doctrine, PostgreSQL, Twig, TypeScript et Vue 3.
> Projet de formation (parcours Symfony — Dyma).

---

## 2. Version moyenne (~120 mots)

> **Wonder** est une plateforme communautaire de questions/réponses développée avec
> **Symfony 6.2**, dans le cadre du parcours Symfony de la plateforme **Dyma**.
>
> Les utilisateurs s'inscrivent avec une photo de profil, posent des questions, y répondent
> et votent (pour / contre) sur les questions comme sur les réponses. Une barre de recherche
> instantanée en **Vue 3** interroge l'API interne en temps réel, et un back-office
> **EasyAdmin** permet de gérer les membres, les rôles et la modération des commentaires.
>
> J'y ai implémenté l'authentification complète (authenticator personnalisé, *remember me*,
> limitation des tentatives de connexion), la réinitialisation de mot de passe par email avec
> token à durée de vie limitée, l'upload d'images, ainsi que des requêtes Doctrine optimisées
> pour éviter le problème des requêtes N+1.

---

## 3. Version longue (page projet dédiée)

### Wonder — Plateforme de questions/réponses

**Contexte.** Projet fil rouge réalisé dans le cadre du parcours **Symfony** de la plateforme
de formation **Dyma**. L'objectif : construire de A à Z une application web complète, de la
modélisation de la base de données jusqu'au déploiement des assets, sans starter kit ni CMS.

**Le produit.** Wonder est un espace communautaire d'entraide : chacun peut poser une question,
y apporter une réponse, et la communauté fait remonter les meilleurs contenus grâce à un système
de votes. L'ensemble est administrable depuis un back-office dédié.

#### Fonctionnalités

- **Comptes utilisateurs** — inscription avec upload de photo de profil, connexion,
  déconnexion, « se souvenir de moi », email de bienvenue automatique.
- **Sécurité** — authenticator Symfony personnalisé, hachage des mots de passe,
  limitation des tentatives de connexion (3 essais / 5 minutes), zone `/admin` réservée
  au rôle `ROLE_ADMIN`.
- **Mot de passe oublié** — envoi d'un lien de réinitialisation par email, token haché
  en base et valable 2 heures, invalidation de l'ancienne demande à chaque nouvelle requête.
- **Questions & réponses** — publication de questions, fil de réponses, compteur de réponses,
  dates relatives (« il y a 3 heures ») via KnpTimeBundle.
- **Système de votes** — vote positif/négatif sur les questions *et* les réponses, un seul vote
  par utilisateur et par contenu, possibilité d'annuler ou d'inverser son vote, impossibilité
  de voter pour son propre contenu. Le score est stocké sur l'entité pour rester lisible sans
  recalcul à chaque affichage.
- **Recherche instantanée** — composant **Vue 3** avec anti-rebond (*debounce*) qui interroge
  un endpoint JSON Symfony et affiche les suggestions au fil de la frappe.
- **Profils** — page publique par utilisateur et page d'édition de son propre profil
  (changement de photo, changement de mot de passe).
- **Back-office EasyAdmin** — tableau de bord, CRUD des utilisateurs (avec attribution des rôles
  et gestion des avatars) et modération des commentaires.
- **Interface responsive** — intégration maison en SCSS, menu burger, sidebar, messages flash.

#### Stack technique

| Domaine | Technologies |
|---|---|
| Back-end | PHP 8.1, Symfony 6.2, Doctrine ORM, Doctrine Migrations |
| Base de données | PostgreSQL 15 |
| Front-end | Twig, SCSS, TypeScript, Vue 3, Webpack Encore |
| Sécurité | Security Bundle, authenticator custom, Rate Limiter, validation Symfony |
| Emails | Symfony Mailer, TemplatedEmail, Mailcatcher (environnement de dev) |
| Administration | EasyAdmin 4 |
| Outillage | Docker Compose, Yarn, Symfony Maker |

#### Points techniques marquants

- **Modélisation relationnelle** — 5 entités (`User`, `Question`, `Comment`, `Vote`,
  `ResetPassword`) et leurs relations, versionnées par des migrations Doctrine.
- **Optimisation des requêtes** — requêtes DQL avec jointures et `addSelect` pour charger
  une question, ses réponses et leurs auteurs en une seule requête, au lieu de subir le
  problème des requêtes N+1.
- **Logique de vote non triviale** — gérer les trois cas (premier vote, inversion du vote,
  annulation) tout en maintenant un score cohérent a demandé de raisonner sur les états
  possibles plutôt que d'empiler les conditions.
- **Service réutilisable** — un service `Uploader` injecté par autowiring centralise l'upload
  d'images : nom de fichier aléatoire, détection d'extension et suppression de l'ancienne image.
- **Environnement conteneurisé** — PostgreSQL et Mailcatcher lancés via Docker Compose, ce qui
  permet de tester l'envoi réel des emails en local.

#### Ce que ce projet m'a apporté

Ce projet m'a fait passer de la simple utilisation d'un framework à sa vraie compréhension :
le conteneur de services et l'injection de dépendances, le cycle de vie d'une requête Symfony,
le fonctionnement du composant Security, et la façon dont Doctrine traduit un modèle objet en
requêtes SQL — avec l'impact concret que cela a sur les performances. Côté front, j'ai structuré
mes styles en SCSS et introduit Vue 3 uniquement là où l'interactivité le justifiait, plutôt que
de transformer toute l'application en SPA.

#### Suites envisagées

Ajout d'une suite de tests automatisés (PHPUnit / Panther), pagination du fil de questions,
système de tags et de catégories, et réactivation du rate limiter sur la procédure de
réinitialisation de mot de passe.

---

## 4. Liste de tags (pour badges ou filtres)

`PHP 8` · `Symfony 6.2` · `Doctrine ORM` · `PostgreSQL` · `Twig` · `SCSS` · `TypeScript` ·
`Vue 3` · `Webpack Encore` · `EasyAdmin` · `Docker` · `Symfony Mailer` · `Full-stack`

---

## 5. Version anglaise (courte)

> **Wonder — Community Q&A platform**
> Full-stack web application where users ask questions, post answers and upvote the best
> content. Features custom authentication, email-based password reset, image uploads, a live
> search bar and an admin back-office.
> Built with Symfony 6.2, Doctrine, PostgreSQL, Twig, TypeScript and Vue 3.
> Training project — Symfony track, Dyma.

---

## 6. Phrases d'accroche (au choix, pour le haut de la fiche)

- « Poser une question, obtenir une réponse, et laisser la communauté faire remonter la meilleure. »
- « Un Stack Overflow miniature, construit sans raccourci pour comprendre Symfony en profondeur. »
- « Du modèle de données au back-office : une application Symfony full-stack de bout en bout. »
