<div class="row">
    <div class="col-12">
        <div class="form-group">
            <div class="btn-group">
                <button class="btn btn-add borderWhiteRight bg-color" name="submit" value="save" type="submit">Opslaan</button>

                <a href="" id="savetoggle" class="btn btn-add borderWhiteLeft dropdown-toggle dropdown-toggle-split bg-color" data-toggle="dropdown""></a>
                    <div class="dropdown-menu bg-color" aria-labelledby="savetoggle">
                    <button class="dropdown-item btn btn-add bg-color m-0" name="submit" value="saveclose" type="submit">
                        <i class="fas fa-times text-white"></i> Opslaan en sluiten
                    </button>
                    <button class="dropdown-item btn btn-add bg-color m-0" name="submit" value="saveadd" type="submit">
                        <i class="fas fa-plus"></i> Opslaan en nieuwe toevoegen
                    </button>
                    <button class="dropdown-item btn btn-add bg-color m-0" name="submit" value="saveshow" type="submit">
                           <i class="fas fa-tv"></i> Opslaan en tonen
                    </button>
                </div>
            </div>

            {{-- // Old save buttons without dropdown
            <div class="btn-group">
                <button class="btn btn-border" name="submit" value="save" type="submit">Opslaan</button>
                <button class="btn btn-border" name="submit" value="saveclose" type="submit">
                    Opslaan en sluiten
                </button>
                <button class="btn btn-border" name="submit" value="saveadd" type="submit">
                    Opslaan en nieuwe toevoegen
                </button>
                <button class="btn btn-border" name="submit" value="saveshow" type="submit">
                        Opslaan en tonen
                </button>
            </div> --}}
        </div>
    </div>
</div>