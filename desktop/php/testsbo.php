<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('testsbo');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter un template}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
	echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity .'"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
}
		    ?>
           </ul>
       </div>
   </div>

   <!-- comment div de la partie page des équipements -->
  <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
    <legend>{{Mes ESXi}}</legend><!-- Titre de la page mes équipements-->
  <legend><i class="fa fa-cog"><!-- Icone engrenage--></i>  {{Gestion}}</legend><!-- Titre de la section de gestions-->
  <div class="eqLogicThumbnailContainer"><!-- Div de la section gestion-->
      <div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
        <i class="fa fa-plus-circle"  style="font-size : 6em;color:#94ca02;"><!-- Icone ajouter un équipement--></i>
        <br>
        <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02">{{Ajouter}}<!-- Test sous l'icone Ajouter--></span>
    </div>
      <div class="cursor eqLogicAction" data-action="gotoPluginConf" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;"><!-- Div pour ouvrir le modal configuration du plugin-->
      <i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i><!-- Icone clé-->
    <br>
    <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676">{{Configuration}}<!-- Test sous l'icone Ajouter--></span>
  </div>
  </div>
  <legend><i class="fa fa-table"></i> {{Mes templates}}</legend><!-- Titre  de la section équipement-->
<div class="eqLogicThumbnailContainer"><!-- Div de la section mes équipements-->
    <?php // Affichage d'un icone par équipement
foreach ($eqLogics as $eqLogic) {
	$opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
	echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
	echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
	echo "<br>";
	echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
	echo '</div>';
}
?>
</div>
</div>
<!-- Section de configuration d'un équipement-->
<div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
	<a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a><!-- Bouton vert et texte sauvegarder-->
  <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a><!-- Bouton rouge et texte supprimer-->
  <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a><!-- Bouton default  et texte configuration avancée-->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li><!-- Bouton retour-->
    <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li><!-- Onglet Equipement-->
    <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li><!-- Onglet Commandes-->
  </ul>
  <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;"><!-- Div de configuration-->
    <div role="tabpanel" class="tab-pane active" id="eqlogictab"><!--Div de l'onglet equipement -->
      <br/>
    <form class="form-horizontal"><!--formulaire horizontal -->
        <fieldset>
            <div class="form-group"><!--formulaire défault (vertical) -->
                <label class="col-sm-3 control-label">{{Nom de l'ESXi}}</label><!--nom de l'equipement -->
                <div class="col-sm-3">
                    <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" /><!-- Retourne l’id(unique) de l’eqLogic(équipement) . Qu’on va pouvoir récupérer via $this->getId()-->
                    <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement template}}"/><!--description dans le champ de saisie -->
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" >{{Objet parent}}</label><!--Titre pour la champ objet parent -->
                <div class="col-sm-3">
                    <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id"><!--sel_object:liste déroulante des objets Jeedom -->
                        <option value="">{{Aucun}}</option>
                        <?php
foreach (object::all() as $object) {
	echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
}
?><!--fonction pour lister les objets -->
                   </select>
               </div>
           </div>
	   <div class="form-group">
                <label class="col-sm-3 control-label">{{Catégorie}}</label><!--Titre de la section catégorie -->
                <div class="col-sm-9">
                 <?php
                    foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                    echo '<label class="checkbox-inline">';
                    echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                    echo '</label>';
                    }
                  ?><!--fonction pour obtenir la liste des catégorie et les afficher en checkbox -->
               </div>
           </div>
	<div class="form-group"><!-- div de la selection active et afficher -->
		<label class="col-sm-3 control-label"></label>
		<div class="col-sm-9">
			<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
			<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
		</div>
	</div>
              <!-- Début de paramétrage des options spécifique de l'équipement -->
	<div class="form-group">
        <label class="col-sm-3 control-label">{{template param 1}}</label><!-- nom du parametre -->
         <div class="col-sm-3"><!-- div de la zone de saisie (taille 3/12 ici)-->
            <input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="city" placeholder="param1"/><!-- input type text : pour champs de saisie texte/datal1key:clé primaire de configuration/data-l2key:clé secondaire/placeholder:description dans la zone de saisie-->
	<!-- c'est moche, voir plus tard -->
	 </div>
	<div class="form-group">
	 <label class="col-sm-3 control-label">{{Mode d'envoi}}</label>
		<div class="col-sm-4">
                    <select class="eqLogicAttr form-control" data-l1key='configuration' data-l2key='sendMode'>
                        <option value='smtp'>SMTP</option>
                        <option value='sendmail'>Sendmail</option>
                        <option value='qmail'>Qmail</option>
                        <option value='mail'>Mail() [PHP fonction]</option>
                    </select>
                </div>
	</div>
</fieldset>
</form>
</div>
<div class="col-sm-4">
    <form class="form-horizontal">
        <fieldset>
            <div class='sendMode sendmail' style="display: none;">
                <div class="alert alert-danger">Attention cette option nécessite d'avoir correctement configurer le système (OS).</div>
            </div>
            <div class='sendMode mail' style="display: none;">
                <div class="alert alert-danger">Attention cette option nécessite d'avoir correctement configurer le système (OS).</div>
            </div>
            <div class='sendMode qmail' style="display: none;">
                <div class="alert alert-danger">Attention cette option nécessite d'avoir correctement configurer le système (OS).</div>
            </div>
            <div class='sendMode smtp' style="display: none;">
                <div class="form-group">
                    <label class="col-sm-4 control-label">{{Serveur SMTP}}</label>
                    <div class="col-sm-6">
                        <input type="text" class="eqLogicAttr form-control" data-l1key='configuration' data-l2key='smtp::server' />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">{{Port SMTP}}</label>
                    <div class="col-sm-6">
                        <input type="text" class="eqLogicAttr form-control" data-l1key='configuration' data-l2key='smtp::port' />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">{{Securité SMTP}}</label>
                    <div class="col-sm-6">
                        <select class="eqLogicAttr form-control" data-l1key='configuration' data-l2key='smtp::security'>
                            <option value=''>{{Aucune}}</option>
                            <option value='tls'>TLS</option>
                            <option value='ssl'>SSL</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">{{Uitlisateur SMTP}}</label>
                    <div class="col-sm-6">
                        <input type="text" class="eqLogicAttr form-control" data-l1key='configuration' data-l2key='smtp::username' />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">{{Mot de passe SMTP}}</label>
                    <div class="col-sm-6">
                        <input type="password" class="eqLogicAttr form-control" data-l1key='configuration' data-l2key='smtp::password' />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-6">
                     <label class="control-label"><input type="checkbox" class="eqLogicAttr" data-l1key='configuration' data-l2key='smtp::dontcheckssl' />{{Ne pas verifier le certificat SSL}}</label>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>
</div>
</div>


<!-- END Section de configuration d'un équipement-->
      <div role="tabpanel" class="tab-pane" id="commandtab"><!-- Onglet de l'onglet commande -->
<a class="btn btn-success btn-sm cmdAction pull-right" data-action="add" style="margin-top:5px;"><i class="fa fa-plus-circle"></i> {{Commandes}}</a><br/><br/>
<table id="table_cmd" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>{{Nom}}</th><th>{{Type}}</th><th>{{Action}}</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>
</div>

</div>
<!--suppresion d'un div -->
<?php include_file('desktop', 'testsbo', 'js', 'testsbo');?>
<?php include_file('core', 'plugin.template', 'js');?>
