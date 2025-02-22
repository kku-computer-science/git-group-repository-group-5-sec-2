*** Settings ***
Documentation     This is a test suite for invalid creating a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TITLE}             งานวิจัยดีเด่น
${DESCRIPTION}       วิทยาลัยการคอมพิวเตอร์ มข. ขอแสดงความยินดีกับ นายภูมินทร์ ดวนขันธ์ ในโอกาสได้รับรางวัล วิทยานิพนธ์ดีเด่น ประจำปี 2567
${PICTURE_PATH}      ${CURDIR}\\highlight.png
${Researcher_ID}     2
${PAPER_INDEX}       1
${PAPER_NOT_SELECT}  0
${IS_SELECTED}       1



*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Go To Create Highlight Page
    Go To Highlight Setting Page
    Title Should Be    Highlight Papers
    Click Highlight Create Button
    Title Should Be    Create Highlight Paper

Title Can Not Be Null
    Fill Highlight Form With Validation    ${EMPTY}    ${DESCRIPTION}    ${PICTURE_PATH}   ${Researcher_ID}    ${PAPER_INDEX}    ${IS_SELECTED}
    Element Should Contain    xpath=//div[@class='alert alert-danger']    The title field is required.
    Title Should Be    Create Highlight Paper            
Description Can Be Null
    Fill Highlight Form With Validation    ${TITLE}    ${EMPTY}    ${PICTURE_PATH}  ${Researcher_ID}    ${PAPER_INDEX}    ${IS_SELECTED}
    Title Should Be    Highlight Papers
Picture Can Be Null
    Go back to Create Highlight
    Fill Highlight Form With Validation Without Image    ${TITLE}    ${DESCRIPTION}    ${Researcher_ID}    ${PAPER_INDEX}    ${IS_SELECTED}
    Title Should Be    Highlight Papers        
Researcher Can Be Null
    Go back to Create Highlight
    Fill Highlight Form With Validation    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${EMPTY}    ${PAPER_INDEX}    ${IS_SELECTED}
    Title Should Be    Highlight Papers
Paper Can Not Be Null
    Go back to Create Highlight
    Fill Highlight Form With Validation    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${Researcher_ID}    ${PAPER_NOT_SELECT}    ${IS_SELECTED}
    Element Should Contain    xpath=//div[@class='alert alert-danger']    The paper id field is required.
    Title Should Be    Create Highlight Paper         
IsSelected Can Be Null
    Fill Highlight Form With Validation Without IsSelected    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}   ${Researcher_ID}     ${PAPER_INDEX}
    Title Should Be    Highlight Papers
    Sleep    3s
    [Teardown]    Close Browser

*** Keywords ***
Click Highlight Create Button
    Click Link    xpath=//a[@class='fw-bold btn btn-primary']  # click the create highlight button

Fill Highlight Form With Validation
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}    ${RESEARCHER_ID}    ${PAPER_INDEX}    ${IS_SELECTED}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//input[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@id='researcherSelect']    ${RESEARCHER_ID}
    Select From List By Index    xpath=//select[@id='paperSelect']    ${PAPER_INDEX}    # select the first paper
    Select From List By Value    xpath=//select[@name='isSelected']    ${IS_SELECTED}      # click for display highlight at the home page
    Scroll Element Into View     xpath=//button[@class='btn btn-primary']
    Click Button     xpath=//button[@class='btn btn-primary']     # click the create highlight button
    Click Button     xpath=//button[@id='confirmCreateBtn']       # confirm the creation of the highlight

Fill Highlight Form With Validation Without Image
    [Arguments]    ${TITLE}    ${DESCRIPTION}   ${RESEARCHER_ID}    ${PAPER_INDEX}   ${IS_SELECTED}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//input[@name='description']    ${DESCRIPTION}
    Select From List By Value    xpath=//select[@id='researcherSelect']    ${RESEARCHER_ID}
    Select From List By Index    xpath=//select[@id='paperSelect']    ${PAPER_INDEX}    # select the first paper
    Select From List By Value    xpath=//select[@name='isSelected']    ${IS_SELECTED}      # click for display highlight at the home page
    Scroll Element Into View     xpath=//button[@class='btn btn-primary']
    Click Button     xpath=//button[@class='btn btn-primary']     # click the create highlight button
    Click Button     xpath=//button[@id='confirmCreateBtn']       # confirm the creation of the highlight

Fill Highlight Form With Validation Without IsSelected 
    [Arguments]    ${TITLE}    ${DESCRIPTION}    ${PICTURE_PATH}     ${RESEARCHER_ID}    ${PAPER_INDEX}
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//input[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@id='researcherSelect']    ${RESEARCHER_ID}
    Select From List By Index    xpath=//select[@id='paperSelect']    1    # select the first paper
    Scroll Element Into View     xpath=//button[@class='btn btn-primary']
    Click Button     xpath=//button[@class='btn btn-primary']     # click the create highlight button
    Click Button     xpath=//button[@id='confirmCreateBtn']       # confirm the creation of the highlight

Go back to Create Highlight
    Click Link    xpath=//a[@class='fw-bold btn btn-primary']  # click the create highlight button