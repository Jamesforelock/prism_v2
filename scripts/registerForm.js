const toggleSecretCodeInput = () => {
    if($("#employeeCheckBox").prop("checked")) $("#secretCodeInput").css("display", "block")
    else $("#secretCodeInput").css("display", "none")
}